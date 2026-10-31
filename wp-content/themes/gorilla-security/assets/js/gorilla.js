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

	initHeader();
	initMarquee();
	initSteps();
} )();
