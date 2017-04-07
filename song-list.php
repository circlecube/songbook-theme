<?php
$args = array (
	'post_type'             => 'song',
	'posts_per_page'        => -1,
	'pagination'            => false,
	'orderby' 				=> 'title', 
	'order'					=> 'ASC'
);

// The Query
$query = new WP_Query( $args );

// The Loop
if ( $query->have_posts() ) { 
	echo '<ul class="song-list">';
	$count = 0;
	while ( $query->have_posts() ) {
		$query->the_post();
		?>	
			<li class="count_<?php echo $count++; ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
		<?php
	} //endwhile
	echo '</ul>';
} //endif 

?>
