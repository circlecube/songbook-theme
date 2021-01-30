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
		
		<?php
		$songbook_song_artist_tr = 'songbook-all-songs-artists';
		if ( false === ( $songs_artists = get_transient( $songbook_song_artist_tr ) ) ) {
			ob_start();
			?>
			<h1 class="page-title">All Songs</h1>
			<?php get_template_part( 'song', 'list', array(
				'index' =>   true,
				'show_artists' => true,
			) );
			$songs_artists = ob_get_clean();
			set_transient( $songbook_song_artist_tr, $songs_artists, WEEK_IN_SECONDS );
		}
		echo $songs_artists;
		?>

		<hr style="margin: 10rem 0 4rem;" />

		<?php
		$songbook_pop_artist_tr = 'songbook-popular-artists';
		if ( false === ( $popular_artists = get_transient( $songbook_pop_artist_tr ) ) ) {
			ob_start();
			?>
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
							$artist->count > 3 &&
							$artist->name !== 'Traditional'
						) {
						?>
						<li>
							<h1 class="alpha_index"><?php echo $artist->name; ?></h1>
							<?php get_template_part( 'song', 'list', array(
								'artist' => $artist->slug,
							) ); ?>
						</li>
						<?php
						}
					}
				}
				?>
			</ul>
			<?php 
			$popular_artists = ob_get_clean();
			set_transient( $songbook_pop_artist_tr, $popular_artists, WEEK_IN_SECONDS );
		}
		echo $popular_artists;
		?>
		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
