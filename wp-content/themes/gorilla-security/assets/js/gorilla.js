/**
 * Gorilla Security — progressive enhancement only (tabs, stepper, slider, marquee, header state).
 * Content and links must work with this file disabled. No dependencies.
 * Modules are added by /build-section as sections need them.
 */
( function () {
	'use strict';

	document.documentElement.classList.add( 'gs-js' );

	/**
	 * Header: switch from glass to solid once the page scrolls (design-system §6).
	 * Without JS the header keeps its initial state, which is still readable.
	 */
	function initHeader() {
		const header = document.querySelector( '.gs-header' );
		if ( ! header ) {
			return;
		}
		let ticking = false;
		const update = function () {
			header.classList.toggle( 'gs-header--solid', window.scrollY > 8 );
			ticking = false;
		};
		window.addEventListener(
			'scroll',
			function () {
				if ( ! ticking ) {
					ticking = true;
					window.requestAnimationFrame( update );
				}
			},
			{ passive: true }
		);
		update();
	}

	/**
	 * Marquee: duplicate each track so it loops seamlessly, then let CSS scroll it.
	 * Adds a pause/play button (WCAG 2.2.2). Skipped with reduced motion: rows stay static.
	 */
	function initMarquees() {
		const marquees = document.querySelectorAll( '.gs-marquee' );
		if (
			! marquees.length ||
			window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches
		) {
			return;
		}
		const l10n = window.gorillaL10n || {};

		marquees.forEach( function ( marquee ) {
			marquee
				.querySelectorAll( '.gs-marquee__track' )
				.forEach( function ( track ) {
					Array.from( track.children ).forEach( function ( item ) {
						const clone = item.cloneNode( true );
						clone.setAttribute( 'aria-hidden', 'true' );
						clone.setAttribute( 'inert', '' );
						track.appendChild( clone );
					} );
				} );

			const toggle = document.createElement( 'button' );
			toggle.type = 'button';
			toggle.className = 'gs-marquee__toggle gs-ico-pause';
			toggle.setAttribute(
				'aria-label',
				l10n.pauseLogos || 'Pause logo animation'
			);
			toggle.setAttribute( 'aria-pressed', 'false' );
			toggle.addEventListener( 'click', function () {
				const paused = marquee.classList.toggle( 'is-paused' );
				toggle.setAttribute(
					'aria-pressed',
					paused ? 'true' : 'false'
				);
				toggle.classList.toggle( 'gs-ico-pause', ! paused );
				toggle.classList.toggle( 'gs-ico-play', paused );
			} );
			marquee.appendChild( toggle );
			marquee.classList.add( 'is-animated' );
		} );
	}

	/**
	 * Stepper (why us): each step title becomes a button that shows its text and photo.
	 * Without JS every step's text is visible and the first photo shows.
	 */
	function initSteppers() {
		document.querySelectorAll( '.gs-steps' ).forEach( function ( list, n ) {
			const section = list.closest( '.gs-why' ) || list.parentElement;
			const steps = Array.from( list.querySelectorAll( '.gs-step' ) );
			const images = section.querySelectorAll( '.gs-steps__img' );
			const canHover = window.matchMedia( '(hover: hover)' ).matches;

			const activate = function ( index ) {
				steps.forEach( function ( step, i ) {
					step.classList.toggle( 'is-active', i === index );
					const toggle = step.querySelector( '.gs-step__toggle' );
					if ( toggle ) {
						toggle.setAttribute(
							'aria-expanded',
							i === index ? 'true' : 'false'
						);
					}
				} );
				images.forEach( function ( img, i ) {
					img.classList.toggle( 'is-active', i === index );
				} );
			};

			steps.forEach( function ( step, i ) {
				const title = step.querySelector( '.gs-step__title' );
				if ( ! title ) {
					return;
				}
				const text = step.querySelector( '.gs-step__body p' );
				const toggle = document.createElement( 'button' );
				toggle.type = 'button';
				toggle.className = 'gs-step__toggle';
				toggle.textContent = title.textContent;
				toggle.setAttribute(
					'aria-expanded',
					i === 0 ? 'true' : 'false'
				);
				if ( text ) {
					text.id = text.id || 'gs-step-' + n + '-' + i;
					toggle.setAttribute( 'aria-controls', text.id );
				}
				toggle.addEventListener( 'click', function () {
					activate( i );
				} );
				if ( canHover ) {
					step.addEventListener( 'mouseenter', function () {
						activate( i );
					} );
				}
				title.textContent = '';
				title.appendChild( toggle );
			} );
		} );
	}

	/**
	 * Tabs (services): jump links become a WAI-ARIA tablist with automatic activation.
	 * Hover or click selects a tab; arrow keys / Home / End move between tabs;
	 * .gs-arrow buttons step prev/next.
	 * Without JS the links jump to stacked panels.
	 */
	function initTabs() {
		document.querySelectorAll( '.gs-tabs__nav' ).forEach( function ( nav ) {
			const section = nav.parentElement;
			const list = nav.querySelector( '.gs-tabs__list' );
			const tabs = Array.from( nav.querySelectorAll( '.gs-tabs__tab' ) );
			const panels = tabs.map( function ( tab ) {
				return document.getElementById(
					tab.getAttribute( 'href' ).slice( 1 )
				);
			} );
			if ( ! list || panels.includes( null ) ) {
				return;
			}
			let current = 0;

			const select = function ( index, focus ) {
				current = ( index + tabs.length ) % tabs.length;
				tabs.forEach( function ( tab, i ) {
					const on = i === current;
					tab.classList.toggle( 'is-active', on );
					tab.setAttribute( 'aria-selected', on ? 'true' : 'false' );
					tab.tabIndex = on ? 0 : -1;
					panels[ i ].classList.toggle( 'is-active', on );
				} );
				if ( focus ) {
					tabs[ current ].focus();
				}
			};

			list.setAttribute( 'role', 'tablist' );
			tabs.forEach( function ( tab, i ) {
				tab.parentElement.setAttribute( 'role', 'presentation' );
				tab.setAttribute( 'role', 'tab' );
				tab.id = tab.id || panels[ i ].id + '-tab';
				tab.setAttribute( 'aria-controls', panels[ i ].id );
				panels[ i ].setAttribute( 'role', 'tabpanel' );
				panels[ i ].setAttribute( 'aria-labelledby', tab.id );
				tab.addEventListener( 'click', function ( event ) {
					event.preventDefault();
					select( i, false );
				} );
				// Mouse users switch on hover; touch keeps tap-to-select.
				tab.addEventListener( 'mouseenter', function () {
					if ( window.matchMedia( '(hover: hover)' ).matches ) {
						select( i, false );
					}
				} );
				tab.addEventListener( 'keydown', function ( event ) {
					const keys = {
						ArrowRight: current + 1,
						ArrowLeft: current - 1,
						Home: 0,
						End: tabs.length - 1,
					};
					if ( event.key in keys ) {
						event.preventDefault();
						select( keys[ event.key ], true );
					}
				} );
			} );

			section
				.querySelectorAll( '.gs-arrow' )
				.forEach( function ( arrow ) {
					arrow.addEventListener( 'click', function () {
						select(
							current +
								( 'prev' === arrow.dataset.gsDir ? -1 : 1 ),
							false
						);
					} );
				} );

			const fromHash = function () {
				return panels.findIndex( function ( panel ) {
					return '#' + panel.id === window.location.hash;
				} );
			};
			select( Math.max( fromHash(), 0 ), false );
			window.addEventListener( 'hashchange', function () {
				if ( fromHash() > -1 ) {
					select( fromHash(), false );
				}
			} );
		} );
	}

	/**
	 * Slider: .gs-arrow buttons (aria-controls = track id) scroll a .gs-slider__track by one card.
	 * The track is a native scroll-snap scroller, so without JS it still scrolls by touch/trackpad.
	 */
	function initSliders() {
		const smooth = window.matchMedia( '(prefers-reduced-motion: reduce)' )
			.matches
			? 'auto'
			: 'smooth';

		document
			.querySelectorAll( '.gs-slider__track[id]' )
			.forEach( function ( track ) {
				const arrows = document.querySelectorAll(
					'.gs-arrow[aria-controls="' + track.id + '"]'
				);
				const section = track.closest( '.alignfull' );
				const heading = section && section.querySelector( 'h2' );

				// Figma's slider loops the reviews 4× (1:418); copies are decorative.
				if ( track.classList.contains( 'gs-slider__track--repeat' ) ) {
					const cards = Array.from( track.children );
					for ( let copy = 0; copy < 3; copy++ ) {
						cards.forEach( function ( card ) {
							const clone = card.cloneNode( true );
							clone.setAttribute( 'aria-hidden', 'true' );
							clone.setAttribute( 'inert', '' );
							clone.removeAttribute( 'id' );
							track.appendChild( clone );
						} );
					}
				}

				track.setAttribute( 'role', 'region' );
				track.setAttribute( 'tabindex', '0' );
				if ( heading ) {
					track.setAttribute( 'aria-label', heading.textContent );
				}

				const step = function () {
					const cards = track.children;
					return cards.length > 1
						? Math.abs(
								cards[ 1 ].offsetLeft - cards[ 0 ].offsetLeft
						  )
						: track.clientWidth;
				};
				const update = function () {
					const max = track.scrollWidth - track.clientWidth - 1;
					const pos = Math.abs( track.scrollLeft );
					arrows.forEach( function ( arrow ) {
						arrow.disabled =
							'prev' === arrow.dataset.gsDir
								? pos <= 1
								: pos >= max;
					} );
				};

				arrows.forEach( function ( arrow ) {
					arrow.addEventListener( 'click', function () {
						const rtl =
							'rtl' ===
							window.getComputedStyle( track ).direction;
						const dir =
							( 'prev' === arrow.dataset.gsDir ? -1 : 1 ) *
							( rtl ? -1 : 1 );
						track.scrollBy( {
							left: dir * step(),
							behavior: smooth,
						} );
					} );
				} );
				track.addEventListener( 'scroll', update, { passive: true } );
				window.addEventListener( 'resize', update );
				update();
			} );
	}

	initHeader();
	initMarquees();
	initSteppers();
	initTabs();
	initSliders();
} )();
