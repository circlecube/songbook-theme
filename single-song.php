<?php
/**
 * The Template for displaying all song posts.
 *
 * @package songbook
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php //get_template_part( 'content', 'single' ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<h2 class="entry-subtitle artist">By <?php echo get_the_term_list( $post->ID, 'artist', '', ', ', '' ); ?></h2>
		<div class="entry-meta">
			<?php //songbook_posted_on(); ?>
			<div id="chord_container_guitar" class="chord_container">
				<h3>Guitar</h3>
			</div>
			<div id="chord_container_ukulele" class="chord_container">
				<h3>Ukulele</h3>
			</div>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->
	
	<?php if ( get_field('chordpro') ) { ?>
		<div class="chordpro-content">
			<?php echo print_chordpro( get_field('chordpro') ); ?>
		</div>
	<?php } ?>

	<?php if ( have_rows('song_part') ) { ?>
		<div class="song-parts">
		<?php
			$song_parts = [];
			while ( have_rows('song_part') ){
				the_row();
				if( get_row_layout() == 'song_part' ){
					// the_sub_field('song_part_title');
					// echo print_chordpro( get_sub_field('song_part_content') );
					//if song part. create song part object and then add to song_parts array
					$song_part = [
						"title" => get_sub_field('song_part_title'),
						"chordpro" => print_chordpro( get_sub_field('song_part_content') ),
					];
					//$song_part->title = get_sub_field('song_part_title');
					//$song_part->chordpro = print_chordpro( get_sub_field('song_part_content') );
					$song_parts[] = $song_part;
					echo '<div class="chordpro-content">';
					echo '<h3 class="song-part-title">'.$song_part["title"].'</h3>';
					echo $song_part["chordpro"];
					echo '</div>';
				}
				elseif( get_row_layout() == 'repeat_song_part' ){
					//if repeat. get song parts array that matches name and echo it's content out.
					//if ( get_sub_field('song_repeat_title') ) {

					echo '<div class="chordpro-content">';
						//echo '<h3>Repeat ' . get_sub_field('song_repeat_title').'</h3>';
						for ($i=0; $i<count($song_parts); $i++){
							$song_part = $song_parts[$i];
							if ( get_sub_field('song_repeat_title') == $song_part["title"] ) {
								echo '<h3 class="song-part-title">'.$song_part["title"].' *</h3>';
								echo $song_part["chordpro"];
							}
						}
					echo '</div>';
					//}
				}
			}//endwhile
			//$chordpro_html = print_chordpro( get_field('chordpro') );
			//print song
			//echo $chordpro_html;
			?>
		</div>
	<?php }//endif ?>

	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->

	<!-- https://vexflow.com/vextab/tutorial.html -->
	<?php if ( get_field('vextab') ) { ?>
		<div 
			class="vextab-auto"
			width=680 
			scale=1.0 
			editor="true"
			editor_width=680 
			editor_height=330
		>
			<?php the_field('vextab'); ?>
		</div>
	<?php } ?>


	<footer class="entry-meta">
		<?php
			//chords - create vexchord data object to build chord charts
			$chords = get_the_terms( $post->ID, 'chord' );
			if ( $chords && ! is_wp_error( $chords ) ) { 
				?>
				<script>
					var CHORD_CHARTS = [<?php							
					$chords_array = array();
					foreach ( $chords as $term ) {
					?>
						{
							name: '<?php echo $term->name; ?>',
							id: '<?php echo $term->term_id; ?>',
							edit_link: '<?php echo get_edit_term_link( $term->term_id, 'chord' );?>',
							guitar: {
								chord: [<?php
								if( have_rows( 'chord_chart', $term ) ):
									$string_num = 1;
									// Loop through rows.
									while( have_rows( 'chord_chart', $term ) ) : the_row();
										echo '[' . $string_num++ . ', ';
										// Load sub field value.
										$string = get_sub_field('string');
										echo '"' . $string['fret'] . '"';
										if ( '' !== $string['label'] ) {
											echo ', ';
											echo '"' . $string['label'] . '"';
										}
										echo ']';
										if ( 6 >= $string_num )
											echo ', ';
									// End loop.
									endwhile;

								// No value.
								else :
									echo '[1,0],[2,0],[3,0],[4,0],[5,0],[6,0]';
								endif;
								?>],
								name: '<?php echo $term->name; ?>',
								id: '<?php echo $term->term_id; ?>',
								tuning: ['E', 'A', 'D', 'G', 'B', 'E'],
								numStrings: 6,
							},
							ukulele: {
								chord: [<?php
								if( have_rows( 'chord_chart_uke', $term ) ):
									$string_num = 1;
									// Loop through rows.
									while( have_rows( 'chord_chart_uke', $term ) ) : the_row();
										echo '[' . $string_num++ . ', ';
										// Load sub field value.
										$string = get_sub_field('string');
										echo '"' . $string['fret'] . '"';
										if ( '' !== $string['label'] ) {
											echo ', ';
											echo '"' . $string['label'] . '"';
										}
										echo ']';
										if ( 6 >= $string_num )
											echo ', ';
									// End loop.
									endwhile;

								// No value.
								else :
									echo '[1,0],[2,0],[3,0],[4,0]';
								endif;
								?>],
								name: '<?php echo $term->name; ?>',
								id: '<?php echo $term->term_id; ?>',
								tuning: ['G', 'C', 'E', 'A'],
								numStrings: 4,
							},
						},<?php
					}
					?>];
				</script>
				<?php
			}

			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ', ', 'songbook' ) );
			//print_r($category_list);
			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'songbook' ) );

			/* get_the_term_list( $id, $taxonomy, $before, $sep, $after ) */
			$genre_list = get_the_term_list( $post->ID, 'genre', '<span class="terms terms--genre">', '<span class="sep">,</span> ', '</span>' );
			$chord_list = get_the_term_list( $post->ID, 'chord', '<span class="terms terms--chord">', '<span class="sep">,</span> ', '</span>' );
			$artist_list = get_the_term_list( $post->ID, 'artist', '<span class="terms terms--artist">', '<span class="sep">,</span> ', '</span>' );
			$meta_text = __( 'This %3$s song is categorized as %1$s<span class="terms--chords"> and has the chords %2$s</span>.', 'songbook' );


			printf(
				$meta_text,
				$genre_list,
				$chord_list,
				$artist_list,
				get_permalink()
			);
		?>

		<?php edit_post_link( __( 'Edit', 'songbook' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>