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

	initHeader();
	initMarquees();
	initSteppers();
} )();
