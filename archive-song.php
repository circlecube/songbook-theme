<?php
/**
 * Template Name: Songs Index
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package songbook
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<h1 class="page-title">All Songs</h1>
		<?php get_template_part( 'song', 'list', array(
			'index' =>   true,
			'show_artists' => true,
		) ); ?>

		<hr style="margin: 10rem 0 4rem;" />

		<h1 class="page-title">Popular Artists</h1>
		<ul class="song-list">
		<?php 
		$artists = get_terms( array(
			'taxonomy' => 'artist',
			'orderby' => 'name',
            'order' => 'ASC',
			'hide_empty' => true,
		) );
		if( !empty($artists)) {
			foreach( $artists as $artist ) {
				if ( 
					$artist->count > 1 &&
					$artist->name !== 'Traditional'
				) {
				?>
				<li><h1 class="alpha_index"><?php echo $artist->name; ?></h1></li>

				<?php get_template_part( 'song', 'list', array(
					'artist' => $artist->slug,
				) ); ?>
				<?php
				}
			}
		}
		?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
