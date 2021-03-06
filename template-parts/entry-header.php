<?php
/**
 * Displays the post header
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since 1.0.0
 */

$entry_header_classes = '';

if ( is_singular() ) {
	$entry_header_classes .= ' header-footer-group';
}

if ( !is_front_page() ) {

?>

	<header class="entry-header has-text-align-center<?php echo esc_attr( $entry_header_classes ); ?>">

		<?php 

			// render banner spacer

				$banner_args = array(
					'post_type'   => 'banner_content',
					'post_status' => 'publish',
				);
				
				$banner_content = new WP_Query( $banner_args );

				if ( $banner_content->have_posts() ) :

					echo '<div id="banner-spacer"></div>';

				endif;

		?>

		<div class="entry-header-inner section-inner medium">

			<?php
				/**
				 * Allow child themes and plugins to filter the display of the categories in the entry header.
				 *
				 * @since 1.0.0
				 *
				 * @param bool   Whether to show the categories in header, Default true.
				 */
			$show_categories = apply_filters( 'twentytwenty_show_categories_in_entry_header', true );

			if ( true === $show_categories && has_category() ) {
				?>

				<div class="entry-categories">
					<span class="screen-reader-text"><?php _e( 'Categories', 'twentytwenty' ); ?></span>
					<div class="entry-categories-inner">
						<?php the_category( ' ' ); ?>
					</div><!-- .entry-categories-inner -->
				</div><!-- .entry-categories -->

				<?php
			}


			// add breadcrumbs
			if ( function_exists('yoast_breadcrumb') ) {
				echo '<div class="breadcrumb-wrapper">';
				yoast_breadcrumb('<p id="breadcrumbs">','</p>');
				echo '</div>';
			}

			// add title for Events
			if ( tribe_is_event_query() ) {
				echo '<h1 class="entry-title">Events</h1>';
			}

			elseif ( is_singular() ) {
				the_title( '<h1 class="entry-title">', '</h1>' );
			} else {
				the_title( '<h2 class="entry-title heading-size-1"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' );
			}

			$intro_text_width = '';

			if ( is_singular() ) {
				$intro_text_width = ' small';
			} else {
				$intro_text_width = ' thin';
			}

			if ( has_excerpt() && is_singular() ) {
				?>

				<div class="intro-text section-inner max-percentage<?php echo $intro_text_width; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output ?>">
					<?php the_excerpt(); ?>
				</div>

				<?php
			}

			if ( !tribe_is_event_query() ) {
				// Default to displaying the post meta.
				twentytwenty_the_post_meta( get_the_ID(), 'single-top' );
			}
			?>

		</div><!-- .entry-header-inner -->

	</header><!-- .entry-header -->

<?php } ?>