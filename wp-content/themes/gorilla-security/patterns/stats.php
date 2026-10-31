<?php
/**
 * Title: Stats
 * Slug: gorilla-security/stats
 * Categories: gorilla-components
 * Keywords: stats, numbers, counters, figures
 * Description: Row of headline numbers with labels, separated by vertical dividers (Figma 1:12).
 *
 * Copy is from Figma 1:12, pending content-writer confirmation in docs/copy/home.md.
 *
 * @package gorilla-security
 */

$gs_stats = array(
	array( __( '6+', 'gorilla-security' ), __( 'Security Solutions', 'gorilla-security' ) ),
	array( __( '600+', 'gorilla-security' ), __( 'Homes & Businesses', 'gorilla-security' ) ),
	array( __( '1000+', 'gorilla-security' ), __( 'Happy Customers', 'gorilla-security' ) ),
);
?>
<!-- wp:columns {"isStackedOnMobile":false,"className":"is-style-stats-with-dividers"} -->
<div class="wp-block-columns is-not-stacked-on-mobile is-style-stats-with-dividers">
<?php
foreach ( $gs_stats as $gs_stat ) :
	if ( '' === trim( $gs_stat[0] ) ) {
		continue;
	}
	?>
<!-- wp:column {"className":"gs-stat"} -->
<div class="wp-block-column gs-stat">
	<?php echo wp_kses_post( gs_paragraph( $gs_stat[0], '', '', 'gs-stat__num' ) ); ?>
	<?php echo wp_kses_post( gs_paragraph( $gs_stat[1], '', '', 'gs-stat__label' ) ); ?>
</div>
<!-- /wp:column -->
<?php endforeach; ?>
</div>
<!-- /wp:columns -->
