/**
 * Gorilla Security — progressive enhancement only (tabs, stepper, slider, marquee, header state).
 * Content and links must work with this file disabled. No dependencies.
 * Modules are added by /build-section as sections need them.
 */
( function () {
	'use strict';

	document.documentElement.classList.add( 'gs-js' );

	const reduceMotion = window.matchMedia(
		'(prefers-reduced-motion: reduce)'
	);
	let uid = 0;
	const ensureId = ( el, prefix ) => {
		if ( ! el.id ) {
			uid += 1;
			el.id = prefix + '-' + uid;
		}
		return el.id;
	};

	/*
	 * Desktop hover intent: run fn once a mouse has moved onto `el` and rested for a moment. Touch and pen never
	 * trigger it (click/tap still does), and a layout shift under a still pointer doesn't count as movement —
	 * so opening one accordion item can't chain-activate the item that slides under the cursor.
	 */
	const finePointer = window.matchMedia(
		'(hover: hover) and (pointer: fine)'
	);
	let lastX = -1;
	let lastY = -1;
	const onHoverIntent = ( el, fn ) => {
		let timer = 0;
		el.addEventListener( 'pointermove', ( event ) => {
			const moved = event.clientX !== lastX || event.clientY !== lastY;
			lastX = event.clientX;
			lastY = event.clientY;
			if (
				! moved ||
				event.pointerType !== 'mouse' ||
				! finePointer.matches
			) {
				return;
			}
			window.clearTimeout( timer );
			timer = window.setTimeout( fn, 180 );
		} );
		el.addEventListener( 'pointerleave', () =>
			window.clearTimeout( timer )
		);
	};

	/*
	 * Tabs (WAI-ARIA tabs, automatic activation). Markup:
	 * .gs-tabs > .gs-tabs__nav > button.gs-tabs__tab × n, followed by .gs-tabs__panel × n (same order).
	 * Without JS the nav is hidden by CSS and every panel shows with its own heading.
	 */
	function initTabs( root ) {
		const tabs = Array.from( root.querySelectorAll( '.gs-tabs__tab' ) );
		const panels = Array.from( root.querySelectorAll( '.gs-tabs__panel' ) );
		if ( ! tabs.length || tabs.length !== panels.length ) {
			return;
		}
		const nav = root.querySelector( '.gs-tabs__nav' );
		nav.setAttribute( 'role', 'tablist' );

		const select = ( index, focus ) => {
			tabs.forEach( ( tab, i ) => {
				const on = i === index;
				tab.setAttribute( 'aria-selected', on ? 'true' : 'false' );
				tab.tabIndex = on ? 0 : -1;
				panels[ i ].hidden = ! on;
			} );
			if ( focus ) {
				tabs[ index ].focus();
			}
		};

		tabs.forEach( ( tab, i ) => {
			const panel = panels[ i ];
			tab.setAttribute( 'role', 'tab' );
			tab.setAttribute( 'aria-controls', ensureId( panel, 'gs-panel' ) );
			panel.setAttribute( 'role', 'tabpanel' );
			panel.setAttribute( 'aria-labelledby', ensureId( tab, 'gs-tab' ) );
			panel.tabIndex = 0;
			tab.addEventListener( 'click', () => select( i, false ) );
			onHoverIntent( tab, () => select( i, false ) );
			tab.addEventListener( 'keydown', ( event ) => {
				const last = tabs.length - 1;
				const keys = {
					ArrowRight: i === last ? 0 : i + 1,
					ArrowLeft: i === 0 ? last : i - 1,
					Home: 0,
					End: last,
				};
				if ( event.key in keys ) {
					event.preventDefault();
					select( keys[ event.key ], true );
				}
			} );
		} );

		// Previous/next arrows inside each panel (Figma 1:162). Focus moves to the same arrow in the
		// newly shown panel, so keyboard users are not dropped when the old panel hides.
		root.querySelectorAll( '.gs-tabs__panel .gs-arrow' ).forEach(
			( arrow ) => {
				arrow.addEventListener( 'click', () => {
					const last = tabs.length - 1;
					const current = tabs.findIndex(
						( tab ) =>
							tab.getAttribute( 'aria-selected' ) === 'true'
					);
					const prev = arrow.dataset.gsDir === 'prev';
					const index = prev
						? ( current + last ) % tabs.length
						: ( current + 1 ) % tabs.length;
					select( index, false );
					const twin = panels[ index ].querySelector(
						'.gs-arrow[data-gs-dir="' + arrow.dataset.gsDir + '"]'
					);
					if ( twin ) {
						twin.focus();
					}
				} );
			}
		);

		root.classList.add( 'is-enhanced' );

		// Panel anchors (#cctv-systems …, used by the footer service links): show that tab, then bring the
		// section into view and move focus to the panel (a hidden panel can't be scrolled to natively).
		const showPanel = ( id, scroll ) => {
			const index = panels.findIndex( ( panel ) => panel.id === id );
			if ( index < 0 ) {
				return false;
			}
			select( index, false );
			if ( scroll ) {
				root.scrollIntoView( {
					behavior: reduceMotion.matches ? 'auto' : 'smooth',
				} );
				panels[ index ].focus( { preventScroll: true } );
			}
			return true;
		};
		document.addEventListener( 'click', ( event ) => {
			const link = event.target.closest( 'a[href*="#"]' );
			if ( ! link || event.defaultPrevented ) {
				return;
			}
			const url = new URL( link.href, window.location.href );
			if (
				url.pathname === window.location.pathname &&
				showPanel( decodeURIComponent( url.hash.slice( 1 ) ), true )
			) {
				event.preventDefault();
				window.history.replaceState( null, '', url.hash );
			}
		} );
		const hashId = () =>
			decodeURIComponent( window.location.hash.slice( 1 ) );
		// Back/forward and edited URLs change only the hash (no reload).
		window.addEventListener( 'hashchange', () =>
			showPanel( hashId(), true )
		);
		if ( ! hashId() || ! showPanel( hashId(), true ) ) {
			select( 0, false );
		}
	}

	/*
	 * Stepper: .gs-steps > .gs-steps__media (one image per step) + .gs-steps__list > .gs-step × n.
	 * Each step's heading (.gs-step__title) gets a button.gs-step__toggle (APG accordion pattern);
	 * the active step shows its body and its image. Without JS all steps are open and only the first
	 * image shows.
	 */
	function initSteps( root ) {
		const steps = Array.from( root.querySelectorAll( '.gs-step' ) );
		if ( ! steps.length ) {
			return;
		}
		const media = Array.from(
			root.querySelectorAll( '.gs-steps__media > *' )
		);
		steps.forEach( ( step ) => {
			const title = step.querySelector( '.gs-step__title' );
			if ( title && ! title.querySelector( '.gs-step__toggle' ) ) {
				const button = document.createElement( 'button' );
				button.type = 'button';
				button.className = 'gs-step__toggle';
				while ( title.firstChild ) {
					button.append( title.firstChild );
				}
				title.append( button );
			}
		} );
		const activate = ( index ) => {
			steps.forEach( ( step, i ) => {
				const on = i === index;
				step.classList.toggle( 'is-active', on );
				const toggle = step.querySelector( '.gs-step__toggle' );
				if ( toggle ) {
					toggle.setAttribute(
						'aria-expanded',
						on ? 'true' : 'false'
					);
				}
			} );
			media.forEach( ( item, i ) =>
				item.classList.toggle( 'is-active', i === index )
			);
		};
		steps.forEach( ( step, i ) => {
			const toggle = step.querySelector( '.gs-step__toggle' );
			const body = step.querySelector( '.gs-step__body' );
			if ( toggle ) {
				// A step without a description (06 until its copy arrives) still switches the photo.
				if ( body ) {
					toggle.setAttribute(
						'aria-controls',
						ensureId( body, 'gs-step' )
					);
				}
				toggle.addEventListener( 'click', () => activate( i ) );
				// Hover anywhere on the step (title or body), so moving between them never flickers.
				onHoverIntent( step, () => activate( i ) );
			}
		} );
		root.classList.add( 'is-enhanced' );
		activate( 0 );
	}

	/*
	 * Slider: .gs-slider with .gs-slider__track (CSS scroll-snap; swipe and keyboard scrolling without JS)
	 * and .gs-arrow buttons from gs_arrows() (aria-controls = track id).
	 * Enhanced: an infinite loop (at either end the outermost card is moved to the other end and the scroll
	 * position compensated, so the next move is seamless), autoplay every 3 s with a pause/play button
	 * (WCAG 2.2.2). Autoplay stops while hovered or focused, off screen, in a background tab or under reduced
	 * motion. If every card fits (wide screens), one hidden copy of the cards is appended (aria-hidden + inert:
	 * not read or focusable twice) so the carousel still advances.
	 */
	function initSlider( root ) {
		const track = root.querySelector( '.gs-slider__track' );
		if ( ! track ) {
			return;
		}
		const arrows = Array.from(
			document.querySelectorAll(
				'.gs-arrow[aria-controls="' + track.id + '"]'
			)
		);
		const labels = window.gsL10n || {};
		const step = () => {
			const card = track.firstElementChild;
			const gap =
				parseFloat( window.getComputedStyle( track ).columnGap ) || 0;
			return card
				? card.getBoundingClientRect().width + gap
				: track.clientWidth;
		};
		const scrollable = () => track.scrollWidth > track.clientWidth + 2;
		const move = ( dir ) => {
			if ( ! scrollable() ) {
				return;
			}
			// RTL scrollLeft runs from 0 to negative values.
			const sign =
				window.getComputedStyle( track ).direction === 'rtl' ? -1 : 1;
			const size = step();
			const pos = Math.abs( track.scrollLeft );
			const max = track.scrollWidth - track.clientWidth;
			// Rotate only when a whole one-card step is no longer possible (the moved card is then off screen).
			// Keep the card the reader is looking at in place by measuring it before and after the DOM move —
			// the browser may already re-snap to it, so a fixed compensation would jump.
			const rotateEnd = dir > 0 && pos + size > max + 2;
			const rotateStart = dir < 0 && pos < size - 2;
			if ( rotateEnd || rotateStart ) {
				const trackLeft = track.getBoundingClientRect().left;
				const anchor = Array.from( track.children ).reduce(
					( best, card ) =>
						Math.abs(
							card.getBoundingClientRect().left - trackLeft
						) <
						Math.abs(
							best.getBoundingClientRect().left - trackLeft
						)
							? card
							: best
				);
				const before = anchor.getBoundingClientRect().left;
				// Snapping off for the DOM move: otherwise the browser animates a re-snap that the next
				// scroll interrupts (a lost step).
				track.style.scrollSnapType = 'none';
				if ( rotateEnd ) {
					track.append( track.firstElementChild );
				} else {
					track.prepend( track.lastElementChild );
				}
				track.scrollLeft +=
					anchor.getBoundingClientRect().left - before;
			}
			const go = () => {
				track.style.scrollSnapType = '';
				track.scrollBy( {
					left: dir * sign * size,
					behavior: reduceMotion.matches ? 'auto' : 'smooth',
				} );
			};
			if ( rotateEnd || rotateStart ) {
				window.requestAnimationFrame( go );
			} else {
				go();
			}
		};
		arrows.forEach( ( button ) => {
			button.hidden = false;
			button.addEventListener( 'click', () =>
				move( button.dataset.gsDir === 'prev' ? -1 : 1 )
			);
		} );

		// Autoplay + pause/play toggle (next to the arrows).
		const toggle = document.createElement( 'button' );
		toggle.type = 'button';
		toggle.className = 'gs-arrow gs-slider__toggle';
		toggle.setAttribute( 'aria-controls', track.id );
		if ( arrows[ 0 ] ) {
			arrows[ 0 ].parentElement.append( toggle );
		}
		let timer = 0;
		let userPaused = false;
		let hovering = false;
		let focused = false;
		let visible = false;
		const sync = () => {
			window.clearInterval( timer );
			timer = 0;
			const canPlay = ! reduceMotion.matches && scrollable();
			toggle.hidden = ! canPlay;
			arrows.forEach( ( button ) => {
				button.hidden = ! scrollable();
			} );
			toggle.classList.toggle( 'gs-ico-pause', ! userPaused );
			toggle.classList.toggle( 'gs-ico-play', userPaused );
			toggle.setAttribute(
				'aria-label',
				userPaused
					? labels.playReviews || 'Play'
					: labels.pauseReviews || 'Pause'
			);
			if (
				canPlay &&
				! userPaused &&
				! hovering &&
				! focused &&
				visible &&
				! document.hidden
			) {
				timer = window.setInterval( () => move( 1 ), 3000 );
			}
		};
		toggle.addEventListener( 'click', () => {
			userPaused = ! userPaused;
			sync();
		} );
		root.addEventListener( 'pointerenter', () => {
			hovering = true;
			sync();
		} );
		root.addEventListener( 'pointerleave', () => {
			hovering = false;
			sync();
		} );
		// The arrows sit outside .gs-slider (in the section head); include them in the focus/hover area.
		const zones = [ root, ...arrows.map( ( a ) => a.parentElement ) ];
		zones.forEach( ( zone ) => {
			zone.addEventListener( 'focusin', () => {
				focused = true;
				sync();
			} );
			zone.addEventListener( 'focusout', ( event ) => {
				focused = zones.some( ( z ) =>
					z.contains( event.relatedTarget )
				);
				sync();
			} );
		} );
		if ( 'IntersectionObserver' in window ) {
			new window.IntersectionObserver( ( entries ) => {
				visible = entries[ 0 ].isIntersecting;
				sync();
			} ).observe( track );
		} else {
			visible = true;
		}
		const ensureOverflow = () => {
			if (
				scrollable() ||
				track.dataset.gsLooped ||
				track.children.length < 2
			) {
				return;
			}
			Array.from( track.children ).forEach( ( card ) => {
				const copy = card.cloneNode( true );
				copy.setAttribute( 'aria-hidden', 'true' );
				copy.inert = true;
				copy.classList.add( 'gs-slider__copy' );
				track.append( copy );
			} );
			track.dataset.gsLooped = '1';
		};
		const refresh = () => {
			ensureOverflow();
			sync();
		};
		document.addEventListener( 'visibilitychange', sync );
		reduceMotion.addEventListener( 'change', sync );
		window.addEventListener( 'resize', refresh );
		refresh();
	}

	/*
	 * FAQ hover (desktop mouse only, same hover intent as the steps and tabs): resting on a question opens it;
	 * the browser closes the previously open one (exclusive <details name>). After a click, hover is ignored on
	 * that item until the pointer leaves, so a click-to-close is not reopened. Touch and keyboard use the native
	 * summary toggle (expanded state is exposed by <details>/<summary>).
	 */
	function initDetailsHover() {
		document.querySelectorAll( 'details[name]' ).forEach( ( item ) => {
			const summary = item.querySelector( 'summary' );
			let clicked = false;
			if ( summary ) {
				summary.addEventListener( 'click', () => {
					clicked = true;
				} );
			}
			item.addEventListener( 'pointerleave', () => {
				clicked = false;
			} );
			onHoverIntent( item, () => {
				if ( ! clicked && ! item.open ) {
					item.open = true;
				}
			} );
		} );
	}

	/*
	 * FAQ (core/details with name="gs-faq"): one answer open at a time. Browsers with exclusive <details>
	 * do this natively; this covers older ones.
	 */
	function initExclusiveDetails() {
		if ( 'name' in window.HTMLDetailsElement.prototype ) {
			return;
		}
		document.addEventListener(
			'toggle',
			( event ) => {
				const opened = event.target;
				if (
					! opened.open ||
					! opened.getAttribute ||
					! opened.getAttribute( 'name' )
				) {
					return;
				}
				document
					.querySelectorAll(
						'details[name="' +
							opened.getAttribute( 'name' ) +
							'"][open]'
					)
					.forEach( ( other ) => {
						if ( other !== opened ) {
							other.open = false;
						}
					} );
			},
			true
		);
	}

	/*
	 * Marquee: .gs-marquee > .gs-marquee__track (logo list). JS duplicates the list (aria-hidden)
	 * for a seamless loop and adds a pause/play button (WCAG 2.2.2). Static under reduced motion.
	 */
	function initMarquee( root ) {
		const track = root.querySelector( '.gs-marquee__track' );
		if ( ! track || reduceMotion.matches ) {
			return;
		}
		const clone = track.cloneNode( true );
		clone.setAttribute( 'aria-hidden', 'true' );
		clone
			.querySelectorAll( 'a, button, [tabindex]' )
			.forEach( ( el ) => el.setAttribute( 'tabindex', '-1' ) );
		clone.classList.add( 'gs-marquee__track--clone' );
		track.after( clone );

		const button = document.createElement( 'button' );
		button.type = 'button';
		button.className = 'gs-marquee__toggle';
		const labels = window.gsL10n || {};
		const setState = ( paused ) => {
			root.classList.toggle( 'is-paused', paused );
			button.setAttribute( 'aria-pressed', paused ? 'true' : 'false' );
			button.textContent = paused
				? labels.play || 'Play'
				: labels.pause || 'Pause';
		};
		button.addEventListener( 'click', () =>
			setState( ! root.classList.contains( 'is-paused' ) )
		);
		root.append( button );
		root.classList.add( 'is-animated' );
		setState( false );
	}

	/*
	 * Quote dialog: every link to #quote opens the quote card in a modal <dialog>. The card (with the one
	 * CF7 form instance) is moved from the hero into the dialog while open and back on close, so the page
	 * never holds two copies of the form or its IDs. Without JS the links jump to the card in the hero.
	 */
	function initQuoteDialog() {
		const card = document.getElementById( 'quote' );
		// Only the quote card (a #quote that holds the CF7 form); elsewhere #quote may be a plain heading.
		if (
			! card ||
			! card.querySelector( 'form.wpcf7-form' ) ||
			typeof window.HTMLDialogElement !== 'function'
		) {
			return;
		}
		const labels = window.gsL10n || {};
		const dialog = document.createElement( 'dialog' );
		dialog.className = 'gs-quote-dialog';
		const title = card.querySelector( '.gs-form__title' );
		if ( title ) {
			dialog.setAttribute(
				'aria-labelledby',
				ensureId( title, 'gs-quote-title' )
			);
		}
		const close = document.createElement( 'button' );
		close.type = 'button';
		close.className = 'gs-quote-dialog__close gs-ico-close';
		close.setAttribute( 'aria-label', labels.closeQuote || 'Close' );
		const body = document.createElement( 'div' );
		body.className = 'gs-quote-dialog__body';
		dialog.append( close, body );
		document.body.append( dialog );

		// Keeps the hero's height while the card is in the dialog (no jump behind the backdrop).
		const placeholder = document.createElement( 'div' );
		placeholder.className = 'gs-quote-placeholder';
		let opener = null;

		const open = ( trigger ) => {
			opener = trigger;
			placeholder.style.minBlockSize = card.offsetHeight + 'px';
			card.before( placeholder );
			body.append( card );
			document.documentElement.classList.add( 'gs-dialog-open' );
			dialog.showModal();
			const first = card.querySelector(
				'input:not([type="hidden"]), select, textarea'
			);
			if ( first ) {
				first.focus();
			}
		};
		dialog.addEventListener( 'close', () => {
			placeholder.replaceWith( card );
			document.documentElement.classList.remove( 'gs-dialog-open' );
			if ( opener ) {
				opener.focus();
				opener = null;
			}
		} );
		close.addEventListener( 'click', () => dialog.close() );
		// A click on the dialog element itself (not its content) is a click on the backdrop.
		dialog.addEventListener( 'click', ( event ) => {
			if ( event.target === dialog ) {
				dialog.close();
			}
		} );
		document.addEventListener( 'click', ( event ) => {
			const link = event.target.closest( 'a[href*="#quote"]' );
			if (
				! link ||
				event.defaultPrevented ||
				event.button !== 0 ||
				event.metaKey ||
				event.ctrlKey ||
				event.shiftKey ||
				event.altKey ||
				dialog.open
			) {
				return;
			}
			const url = new URL( link.href, window.location.href );
			if (
				url.hash !== '#quote' ||
				url.origin !== window.location.origin
			) {
				return;
			}
			event.preventDefault();
			open( link );
		} );
	}

	/* Header: solid background once the page scrolls (glass over the hero at the top). */
	function initHeader() {
		const header = document.querySelector( '.gs-header' );
		if ( ! header ) {
			return;
		}
		const update = () =>
			header.classList.toggle( 'is-scrolled', window.scrollY > 24 );
		window.addEventListener( 'scroll', update, { passive: true } );
		update();
	}

	const run = () => {
		document.querySelectorAll( '.gs-tabs' ).forEach( initTabs );
		document.querySelectorAll( '.gs-steps' ).forEach( initSteps );
		document.querySelectorAll( '.gs-slider' ).forEach( initSlider );
		document.querySelectorAll( '.gs-marquee' ).forEach( initMarquee );
		initQuoteDialog();
		initExclusiveDetails();
		initDetailsHover();
		initHeader();
	};

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', run );
	} else {
		run();
	}
} )();
