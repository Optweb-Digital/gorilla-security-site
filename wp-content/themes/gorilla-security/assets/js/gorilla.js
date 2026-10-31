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
	const i18n = window.gsecI18n || {};

	/**
	 * Header: glass over the hero, solid once the page scrolls (Figma 1:523).
	 * Without JS the header is not fixed on hero pages, so it scrolls away instead.
	 */
	function initHeader() {
		const header = document.querySelector( '.gs-header' );
		if ( ! header || ! document.body.classList.contains( 'gs-has-hero' ) ) {
			return;
		}
		const update = function () {
			header.classList.toggle( 'gs-header--solid', window.scrollY > 0 );
		};
		update();
		window.addEventListener( 'scroll', update, { passive: true } );

		// The hero pads its top by the floating header's real height (CSS has a fallback).
		const wrap = header.parentElement;
		const measure = function () {
			document.documentElement.style.setProperty(
				'--gs-header-h',
				wrap.offsetHeight + 'px'
			);
		};
		measure();
		if ( 'ResizeObserver' in window ) {
			new window.ResizeObserver( measure ).observe( wrap );
		}
	}

	/**
	 * Pause/play button shared by the moving components (WCAG 2.2.2). The label states the
	 * action; is-paused on the button swaps its icon.
	 *
	 * @param {string}   modifier   Extra class for placement, e.g. 'gs-marquee__toggle'.
	 * @param {string}   pauseLabel Label while playing.
	 * @param {string}   playLabel  Label while paused.
	 * @param {Function} onToggle   Called with the new paused state after a click.
	 * @return {Object} The button and a setPaused( paused ) function.
	 */
	function playToggle( modifier, pauseLabel, playLabel, onToggle ) {
		const button = document.createElement( 'button' );
		button.type = 'button';
		button.className = 'gs-play-toggle ' + modifier;
		let paused = false;
		const setPaused = function ( value ) {
			paused = value;
			button.classList.toggle( 'is-paused', paused );
			button.setAttribute(
				'aria-label',
				paused ? playLabel : pauseLabel
			);
		};
		setPaused( false );
		button.addEventListener( 'click', function () {
			setPaused( ! paused );
			onToggle( paused );
		} );
		return { button, setPaused };
	}

	/**
	 * Marquee: loop the logo rows (Figma 1:510) with a pause button.
	 * Each row's logos are cloned once (hidden from assistive tech) so the CSS animation can
	 * slide exactly half the row and repeat seamlessly. With reduced motion nothing moves and
	 * the rows stay wrapped, as without JS.
	 */
	function initMarquee() {
		if ( reduceMotion.matches ) {
			return;
		}
		document
			.querySelectorAll( '.gs-marquee' )
			.forEach( function ( marquee ) {
				marquee
					.querySelectorAll( '.gs-marquee__row' )
					.forEach( function ( row ) {
						Array.from( row.children ).forEach( function ( item ) {
							const clone = item.cloneNode( true );
							clone.setAttribute( 'aria-hidden', 'true' );
							clone
								.querySelectorAll( 'img' )
								.forEach( function ( img ) {
									img.alt = '';
								} );
							row.appendChild( clone );
						} );
					} );
				const toggle = playToggle(
					'gs-marquee__toggle',
					i18n.pauseLogos || 'Pause the moving logos',
					i18n.playLogos || 'Play the moving logos',
					function ( paused ) {
						marquee.classList.toggle( 'is-paused', paused );
					}
				);
				marquee.appendChild( toggle.button );
				marquee.classList.add( 'is-animated' );
			} );
	}

	/**
	 * Stepper (Figma 1:522): one reason open at a time, its photo shown, a marker on the track.
	 * Each title becomes a button (aria-expanded) controlling its text. Reasons advance every
	 * --gs-step-duration while the section is on screen and not hovered or focused; the pause
	 * button stops it, and choosing a reason stops it too. No auto-advance with reduced motion.
	 */
	function initSteps() {
		document.querySelectorAll( '.gs-steps' ).forEach( function ( root, n ) {
			const list = root.querySelector( '.gs-steps__list' );
			const steps = Array.from( root.querySelectorAll( '.gs-step' ) );
			if ( ! list || steps.length < 2 ) {
				return;
			}
			const photos = Array.from(
				root.querySelectorAll( '.gs-steps__media > .wp-block-image' )
			);
			let current = 0;
			let timer = null;
			let paused = false;
			let held = false;
			let visible = false;

			const place = function () {
				const step = steps[ current ];
				list.style.setProperty(
					'--gs-step-top',
					step.offsetTop + 'px'
				);
				list.style.setProperty(
					'--gs-step-h',
					step.offsetHeight + 'px'
				);
			};
			const activate = function ( index ) {
				current = index;
				steps.forEach( function ( step, i ) {
					const on = i === index;
					step.classList.toggle( 'is-active', on );
					step.querySelector( '.gs-step__toggle' ).setAttribute(
						'aria-expanded',
						String( on )
					);
					const text = step.querySelector( '.gs-step__text' );
					if ( text ) {
						text.hidden = ! on;
					}
				} );
				photos.forEach( function ( photo, i ) {
					photo.classList.toggle( 'is-active', i === index );
				} );
				place();
			};

			const seconds = parseFloat(
				window
					.getComputedStyle( document.documentElement )
					.getPropertyValue( '--gs-step-duration' )
			);
			const delay = ( seconds > 0 ? seconds : 8 ) * 1000;
			const schedule = function () {
				window.clearTimeout( timer );
				if ( reduceMotion.matches || paused || held || ! visible ) {
					return;
				}
				timer = window.setTimeout( function () {
					activate( ( current + 1 ) % steps.length );
					schedule();
				}, delay );
			};
			const toggle = playToggle(
				'gs-steps__toggle',
				i18n.pauseSteps || 'Pause the reasons slideshow',
				i18n.playSteps || 'Play the reasons slideshow',
				function ( value ) {
					paused = value;
					schedule();
				}
			);

			steps.forEach( function ( step, i ) {
				const title = step.querySelector( '.gs-step__title' );
				const text = step.querySelector( '.gs-step__text' );
				const button = document.createElement( 'button' );
				button.type = 'button';
				button.className = 'gs-step__toggle';
				button.textContent = title.textContent;
				if ( text ) {
					text.id = text.id || 'gs-step-' + n + '-' + i;
					button.setAttribute( 'aria-controls', text.id );
				}
				button.addEventListener( 'click', function () {
					activate( i );
					paused = true;
					toggle.setPaused( true );
					schedule();
				} );
				title.textContent = '';
				title.appendChild( button );
			} );

			// Track and marker as real elements: pseudo-elements with a background on the list
			// make contrast checkers give up on every step inside it.
			const track = document.createElement( 'span' );
			track.className = 'gs-steps__track';
			track.setAttribute( 'aria-hidden', 'true' );
			track.appendChild( document.createElement( 'span' ) ).className =
				'gs-steps__marker';
			list.appendChild( track );

			root.classList.add( 'is-enhanced' );
			activate( 0 );
			if ( ! reduceMotion.matches ) {
				list.after( toggle.button );
			}

			root.addEventListener( 'mouseenter', function () {
				held = true;
				schedule();
			} );
			root.addEventListener( 'mouseleave', function () {
				held = root.contains( root.ownerDocument.activeElement );
				schedule();
			} );
			root.addEventListener( 'focusin', function () {
				held = true;
				schedule();
			} );
			root.addEventListener( 'focusout', function ( event ) {
				held =
					root.contains( event.relatedTarget ) ||
					root.matches( ':hover' );
				schedule();
			} );
			if ( 'IntersectionObserver' in window ) {
				new window.IntersectionObserver( function ( entries ) {
					visible = entries[ 0 ].isIntersecting;
					schedule();
				} ).observe( root );
			}
			if ( 'ResizeObserver' in window ) {
				new window.ResizeObserver( place ).observe( list );
			}
		} );
	}

	/**
	 * Tabs (Figma 1:162), WAI-ARIA tabs pattern with automatic activation. The bar is a list
	 * of jump links to the panels; here the links become tabs (arrow keys, Home, End) and
	 * only the chosen panel shows. Prev/next arrows (gsec_arrows) in the panels step
	 * through the tabs. A #panel-id in the URL opens that tab.
	 */
	function initTabs() {
		document.querySelectorAll( '.gs-tabs' ).forEach( function ( root, n ) {
			const list = root.querySelector( '.gs-tabs__nav' );
			if ( ! list ) {
				return;
			}
			const tabs = Array.from( list.querySelectorAll( 'a[href^="#"]' ) );
			const panels = tabs.map( function ( tab ) {
				return document.getElementById( tab.hash.slice( 1 ) );
			} );
			if ( tabs.length < 2 || panels.indexOf( null ) !== -1 ) {
				return;
			}
			let current = 0;

			const activate = function ( index, focus ) {
				current = ( index + tabs.length ) % tabs.length;
				tabs.forEach( function ( tab, i ) {
					const on = i === current;
					tab.setAttribute( 'aria-selected', String( on ) );
					tab.tabIndex = on ? 0 : -1;
					panels[ i ].hidden = ! on;
				} );
				if ( focus ) {
					tabs[ current ].focus();
				}
			};

			const label = root.querySelector( '.is-style-eyebrow' );
			if ( label ) {
				label.id = label.id || 'gs-tabs-' + n + '-label';
				list.setAttribute( 'aria-labelledby', label.id );
			}
			list.setAttribute( 'role', 'tablist' );
			tabs.forEach( function ( tab, i ) {
				tab.parentElement.setAttribute( 'role', 'presentation' );
				tab.id = tab.id || 'gs-tab-' + n + '-' + i;
				tab.setAttribute( 'role', 'tab' );
				tab.setAttribute( 'aria-controls', panels[ i ].id );
				panels[ i ].setAttribute( 'role', 'tabpanel' );
				panels[ i ].setAttribute( 'aria-labelledby', tab.id );
				tab.addEventListener( 'click', function ( event ) {
					event.preventDefault();
					activate( i );
				} );
			} );

			list.addEventListener( 'keydown', function ( event ) {
				const rtl =
					window.getComputedStyle( list ).direction === 'rtl'
						? -1
						: 1;
				const step = {
					ArrowRight: rtl,
					ArrowLeft: -rtl,
				}[ event.key ];
				if ( step ) {
					activate( current + step, true );
				} else if ( event.key === 'Home' ) {
					activate( 0, true );
				} else if ( event.key === 'End' ) {
					activate( tabs.length - 1, true );
				} else {
					return;
				}
				event.preventDefault();
			} );

			// Arrows live inside the panels: keep focus on the same arrow in the new panel.
			root.querySelectorAll( '.gs-arrow' ).forEach( function ( arrow ) {
				arrow.addEventListener( 'click', function () {
					const dir = arrow.getAttribute( 'data-gs-dir' );
					activate( current + ( dir === 'prev' ? -1 : 1 ) );
					const next = panels[ current ].querySelector(
						'.gs-arrow[data-gs-dir="' + dir + '"]'
					);
					if ( next ) {
						next.focus();
					}
				} );
			} );

			const start = panels.findIndex( function ( panel ) {
				return '#' + panel.id === window.location.hash;
			} );
			activate( Math.max( start, 0 ) );
			root.classList.add( 'is-enhanced' );
		} );
	}

	/**
	 * Slider (Figma 1:418): the track is a scroll-snap row that works on its own; the round
	 * arrows (gsec_arrows) scroll it by one card. The track becomes a labelled, focusable
	 * region so keyboard users can scroll it with the arrow keys.
	 */
	function initSliders() {
		document.querySelectorAll( '.gs-slider' ).forEach( function ( root ) {
			const track = root.querySelector( '.gs-slider__track' );
			if ( ! track || ! track.firstElementChild ) {
				return;
			}
			const heading = root.querySelector( '.wp-block-heading' );
			track.setAttribute( 'role', 'region' );
			track.tabIndex = 0;
			if ( heading ) {
				heading.id = heading.id || track.id + '-label';
				track.setAttribute( 'aria-labelledby', heading.id );
			}
			const rtl = window.getComputedStyle( track ).direction === 'rtl';
			root.querySelectorAll( '.gs-arrow' ).forEach( function ( arrow ) {
				arrow.addEventListener( 'click', function () {
					const card = track.firstElementChild;
					const gap = parseFloat(
						window.getComputedStyle( track ).columnGap
					);
					const step =
						( card.offsetWidth + ( gap || 0 ) ) *
						( arrow.getAttribute( 'data-gs-dir' ) === 'prev'
							? -1
							: 1 ) *
						( rtl ? -1 : 1 );
					track.scrollBy( {
						left: step,
						behavior: reduceMotion.matches ? 'auto' : 'smooth',
					} );
				} );
			} );
			root.classList.add( 'is-enhanced' );
		} );
	}

	initHeader();
	initMarquee();
	initSteps();
	initTabs();
	initSliders();
} )();
