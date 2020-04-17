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

		<div class="entry-meta">
			<?php songbook_posted_on(); ?>
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
					//echo '<h3>'.$song_part["title"].'</h3>';
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
			class="vex-tabdiv"
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
			//chords
			// $chords = get_the_terms( $post->ID, 'chords' );
			// if ( $chords && ! is_wp_error( $chords ) ) { 
			// 	$chords_array = array();
			// 	foreach ( $chords as $term ) {
			// 		$chords_array[] = $term->name;
			// 	}				
			// 	$chords_string = join( " ", $chords_array );
			// 	$shortcode = '[jtab phrase="' . $chords_string . '"]';
			// 	//add guitar chords via custom field or taxonomy and do_shortcode or just use the jtab js.
			// 	echo do_shortcode($shortcode);
			// }
			// echo '<div class="jtabs">';
			// 	foreach ( $chords as $chord ) {
			// 		$shortcode = '[jtab phrase="' . $chord . '"]';
			// 		echo do_shortcode($shortcode);
			// 	}				
				//$chords_string = join( " ", $chords );
				//$shortcode = '[jtab phrase="' . $chords_string . '"]';
				//add guitar chords via custom field or taxonomy and do_shortcode or just use the jtab js.
				//echo do_shortcode($shortcode);
			// echo '</div>';
			//genre

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
<?php
/*
		previous_post_link_plus( array(
                    'order_by' => 'post_title',
                    'before' => '<div class="nav-previous">',
                    'after' => '</div>'
        ) );
		
		next_post_link_plus( array(
                    'order_by' => 'post_title',
                    'before' => '<div class="nav-previous">',
                    'after' => '</div>'
        ) );
*/
			?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() )
					comments_template();
			?>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>