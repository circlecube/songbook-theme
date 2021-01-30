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

<!-- <link rel="manifest" href="manifest.json"> -->

<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="application-name" content="Music">
<meta name="apple-mobile-web-app-title" content="Music">
<meta name="theme-color" content="#000000">
<meta name="msapplication-navbutton-color" content="#000000">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="msapplication-starturl" content="/music/">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link rel="icon" type="image/jpg" sizes="350x350" href="/music/wp-content/themes/songbook-theme/img/music-note.jpg">
<link rel="apple-touch-icon" type="image/jpg" sizes="350x350" href="/music/wp-content/themes/songbook-theme/img/music-note.jpg">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>
	<header id="masthead" class="site-header" role="banner">
		<div class="icon menu">
				<a class="menu-toggle" href="#mmenu">
				<span class="screen-reader-text"><?php _e( 'Menu', 'songbook' ); ?></span>
				<span class="icons icons-menu">
					<svg 
						version="1.1" 
						xmlns="http://www.w3.org/2000/svg" 
						xmlns:xlink="http://www.w3.org/1999/xlink" 
						x="0px" 
						y="0px" 
						width="20" 
						height="20" 
						viewBox="0 0 20 20"
					>
						<path d="M3,15h14v-2H3V15z M3,5v2h14V5H3z M3,11h14V9H3V11z"/>
					</svg>
				</span>
			</a>
		</div>
		<div class="site-branding">
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
		</div>
		<div class="icon options"><a class="menu-toggle options-toggle" href="#options">
			<span class="screen-reader-text"><?php _e( 'Options', 'songbook' ); ?></span>
			<span class="icons icons-admin-generic">
				<svg 
					version="1.1" 
					xmlns="http://www.w3.org/2000/svg" 
					xmlns:xlink="http://www.w3.org/1999/xlink" 
					width="20" 
					height="20" 
					x="0px" 
					y="0px" 
					viewBox="0 0 20 20"
				>
					<path d="M18 12h-2.18c-0.17 0.7-0.44 1.35-0.81 1.93l1.54 1.54-2.1 2.1-1.54-1.54c-0.58 0.36-1.23 0.63-1.91 0.79v2.18h-3v-2.18c-0.68-0.16-1.33-0.43-1.91-0.79l-1.54 1.54-2.12-2.12 1.54-1.54c-0.36-0.58-0.63-1.23-0.79-1.91h-2.18v-2.97h2.17c0.16-0.7 0.44-1.35 0.8-1.94l-1.54-1.54 2.1-2.1 1.54 1.54c0.58-0.37 1.24-0.64 1.93-0.81v-2.18h3v2.18c0.68 0.16 1.33 0.43 1.91 0.79l1.54-1.54 2.12 2.12-1.54 1.54c0.36 0.59 0.64 1.24 0.8 1.94h2.17v2.97zM9.5 13.5c1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3 1.34 3 3 3z"></path>
				</svg>
			</span></a></div>

		<nav id="mmenu" role="navigation">
			<?php
			$songbook_nav_tr = 'songbook-nav-songs';
			if ( false === ( $nav_songs = get_transient( $songbook_nav_tr ) ) ) {
				ob_start();
				get_template_part( 'song', 'list' );
				$nav_songs = ob_get_clean();
				set_transient( $songbook_nav_tr, $nav_songs, HOUR_IN_SECONDS );
			}
			echo $nav_songs;
			?>	
		</nav>

		<nav id="options" role="navigation">
			<ul>
				<li><a href="#" class="dark_mode">✘ Dark Mode</a></li>
				<li><a href="#" class="show_chords">✓ Chords</a></li>
				<li><a href="#" class="guitar">✓ Guitar Chords</a></li>
				<li><a href="#" class="ukulele">✓ Ukulele Chords</a></li>
			</ul>
		</nav>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
