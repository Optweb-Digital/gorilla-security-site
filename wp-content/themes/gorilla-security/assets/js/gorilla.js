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

	initHeader();
	initMarquees();
} )();
