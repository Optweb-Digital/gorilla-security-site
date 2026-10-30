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

	initHeader();
} )();
