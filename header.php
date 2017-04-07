<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package songbook
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>
	<header id="masthead" class="site-header" role="banner">
		<a class="menu-toggle" href="#mmenu"><?php _e( 'Menu', 'songbook' ); ?></a>
		<div class="tools"><a class="menu-toggle options-toggle" href="#momenu"><?php _e( 'Options', 'songbook' ); ?></a></div>
		<div class="site-branding">
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
		</div>

		<nav id="mmenu" role="navigation">
			<?php get_template_part( 'song', 'list' ); ?>
		</nav>
		<nav id="momenu" role="navigation">
			<ul>
				<li><a href="#" class="show_chords">Hide Chords</a></li>
				<li><a href="#" class="colorscheme_dark">Dark</a></li>
			</ul>
		</nav>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
