<?php
/**
 * The template for displaying all chords with a chord diagram.
 *
 * Template Name: Chords
 * 
 * @package songbook
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div id="chord_containter"></div>
			<?php
			//chords - create vexchord data object to build chord charts
			$chords = get_terms( array(
				'taxonomy' => 'chord',
				'hide_empty' => false,
			) );
			if ( $chords && ! is_wp_error( $chords ) ) { 
				?>
				<script>
					var chordCharts = [<?php							
					$chords_array = array();
					foreach ( $chords as $term ) {
					?>
						{
							name: '<?php echo $term->name; ?>',
							id: '<?php echo $term->term_id; ?>',
							edit_link: '<?php echo get_edit_term_link( $term->term_id, 'chord' );?>',
							archive_link: '<?php echo get_term_link($term->term_id, 'chord'); ?>',
							archive_text: '<?php echo $term->count; ?> songs with <?php echo $term->name; ?>',
							<?php //echo get_field( 'chord_data', $term ); ?>
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
						},<?php
					}
					?>];
				</script>
				<?php
			} ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
