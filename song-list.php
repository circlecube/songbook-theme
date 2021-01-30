<?php

// Set defaults.
$args = wp_parse_args(
	$args,
	array(
		'index'        => false,
		'show_artists' => false,
		'artist'       => false, 
	)
);

if ( $args['artist'] ) {
	$tax_query = array(
		array(
			'taxonomy' => 'artist',
			'field'    => 'slug',
			'terms'    => $args['artist']
		)
	);
}

$song_query_args = array (
	'post_type'      => 'song',
	'posts_per_page' => -1,
	'pagination'     => false,
	'orderby'        => 'title', 
	'order'          => 'ASC',
	'tax_query'      => $args['artist'] ? $tax_query : false,
);

// The Query
$song_query = new WP_Query( $song_query_args );

// The Loop
if ( $song_query->have_posts() ) { 
	echo '<ul class="song-list">';
	$count = 0;
	$alpha_count = '';

	while ( $song_query->have_posts() ) {
		$song_query->the_post();

		$title = get_the_title();
		$alpha_title = $title[0];

		if ( $args['index'] && $alpha_count !== $alpha_title ) {
			$alpha_count = $alpha_title;
			if ( 'A' !== $alpha_count ) { // close previous letter
				echo '</ul></li>';
			}
			echo '<li class="alpha_count_'.$alpha_count.'"><h1 class="alpha_index">' . $alpha_count . '</h1><ul class="song-list">';
		}

		if ( $args['show_artists'] ) {
			$artist_list = '';
			// include artist
			$artist_object_list = get_the_terms( $post->ID, 'artist' );
			if ( ! empty( $artist_object_list ) ) {
				$artist_list = join(', ', wp_list_pluck($artist_object_list, 'name'));
			}
		}

		?>	
			<li class="count_<?php echo $count++; ?>">
				<a 
					href="<?php the_permalink(); ?>"
				>
					<?php the_title(); ?>
					<?php echo $args['show_artists'] && !empty( $artist_list ) ? ' - ' . $artist_list : ''; ?>
				</a>
			</li>
		<?php
	} //endwhile
	if ( $args['index'] ) { //close last letter
		echo '</ul></li>';
	}
	echo '</ul>';
} //endif 

?>
