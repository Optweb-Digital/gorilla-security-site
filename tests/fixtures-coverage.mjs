/**
 * Fails when a section pattern is missing from the fixtures stress page (AGENTS.md §6, rules-log 014).
 *
 * A pattern counts as covered when the stress page, a template part or a covered pattern references it.
 * Exceptions need a reason.
 */
import { readFileSync, readdirSync } from 'node:fs';

const theme = 'wp-content/themes/gorilla-security';
const exceptions = {
	hero: 'carries the page H1; pa11y and Lighthouse test it on the home page',
};

const xml = readFileSync( 'fixtures/content.xml', 'utf8' );
const page = xml
	.split( '<item>' )
	.find( ( item ) => item.includes( '<wp:post_name><![CDATA[fixtures-stress-test]]>' ) );
if ( ! page ) {
	console.error( 'fixtures-coverage: stress page not found in fixtures/content.xml' );
	process.exit( 1 );
}

const refs = ( text ) =>
	[ ...text.matchAll( /wp:pattern \{"slug":"gorilla-security\/([a-z0-9-]+)"/g ) ].map( ( m ) => m[ 1 ] );

const patterns = {};
for ( const file of readdirSync( `${ theme }/patterns` ).filter( ( f ) => f.endsWith( '.php' ) ) ) {
	const src = readFileSync( `${ theme }/patterns/${ file }`, 'utf8' );
	const slug = ( src.match( /Slug:\s*gorilla-security\/([a-z0-9-]+)/ ) || [] )[ 1 ];
	if ( slug ) {
		patterns[ slug ] = refs( src );
	}
}

const covered = new Set();
const visit = ( slug ) => {
	if ( covered.has( slug ) ) {
		return;
	}
	covered.add( slug );
	( patterns[ slug ] || [] ).forEach( visit );
};
refs( page ).forEach( visit );
for ( const part of readdirSync( `${ theme }/parts` ) ) {
	refs( readFileSync( `${ theme }/parts/${ part }`, 'utf8' ) ).forEach( visit );
}
Object.keys( exceptions ).forEach( ( slug ) => ( patterns[ slug ] || [] ).forEach( visit ) );

const missing = Object.keys( patterns ).filter( ( slug ) => ! covered.has( slug ) && ! exceptions[ slug ] );
if ( missing.length ) {
	console.error( `fixtures-coverage: not on the stress page: ${ missing.join( ', ' ) }` );
	process.exit( 1 );
}
console.log( `fixtures-coverage: ${ Object.keys( patterns ).length } patterns covered (${ Object.keys( exceptions ).length } by exception)` );
