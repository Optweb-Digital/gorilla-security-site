/**
 * Gorilla Security — progressive enhancement only (tabs, stepper, slider, marquee, header state).
 * Content and links must work with this file disabled. No dependencies.
 * Modules are added by /build-section as sections need them.
 */
( function () {
	'use strict';

	document.documentElement.classList.add( 'gs-js' );

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

	initHeader();
} )();
