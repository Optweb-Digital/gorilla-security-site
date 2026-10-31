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

	/**
	 * Marquee: loop the logo rows (Figma 1:510) with a pause button (WCAG 2.2.2).
	 * Each row's logos are cloned once (hidden from assistive tech) so the CSS animation can
	 * slide exactly half the row and repeat seamlessly. With reduced motion nothing moves and
	 * the rows stay wrapped, as without JS.
	 */
	function initMarquee() {
		const reduce = window.matchMedia( '(prefers-reduced-motion: reduce)' );
		if ( reduce.matches ) {
			return;
		}
		const i18n = window.gsecI18n || {};
		const pauseLabel = i18n.pauseLogos || 'Pause the moving logos';
		const playLabel = i18n.playLogos || 'Play the moving logos';

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

				const toggle = document.createElement( 'button' );
				toggle.type = 'button';
				toggle.className = 'gs-marquee__toggle';
				toggle.setAttribute( 'aria-label', pauseLabel );
				toggle.addEventListener( 'click', function () {
					const paused = marquee.classList.toggle( 'is-paused' );
					toggle.setAttribute(
						'aria-label',
						paused ? playLabel : pauseLabel
					);
				} );
				marquee.appendChild( toggle );
				marquee.classList.add( 'is-animated' );
			} );
	}

	initHeader();
	initMarquee();
} )();
