<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage nlwc
 * @since 4.2012
 */
?><!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'nlwc' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
		
	/* Adds Jquery functionality */
	wp_enqueue_script("jquery"); 

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
	
?>

<link rel="stylesheet" href="<?php bloginfo("template_url") ?>/nivo-slider.css">

<script type="text/javascript"
   src="<?php bloginfo("template_url"); ?>/js/jquery-1.7.2.min.js"></script>
   
<script type="text/javascript"
   src="<?php bloginfo("template_url"); ?>/js/scripts.js"></script>
   
<script type="text/javascript"
   src="<?php bloginfo("template_url"); ?>/js/jquery.nivo.slider.js"></script>
   
<script type="text/javascript"
   src="<?php bloginfo("template_url"); ?>/js/jquery.tablesorter.min.js"></script>
   
<script type="text/javascript">
// Popup window code
function newPopup(url) {
	popupWindow = window.open(
		url,'popUpWindow','height=700,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes')
}
</script>
   
</head>

<body <?php body_class(); ?>>

<div id="topbar">
	<div id="topbar_wrap">
    	<ul>
        	<li id="login"><?php wp_loginout(); ?></li>
            <li>
            	<a href="http://www.facebook.com/pages/New-Life-Worship-Center-Gladewater/132937660054214" target="_blank"><img src="<?php bloginfo("template_url"); ?>/images/fbicon.png" id="fbicon" /></a>
            </li>
            
            <li>
            	<?php
						// Has the text been hidden?
						if ( 'blank' == get_header_textcolor() ) :
					?>
						<div class="only-search<?php if ( ! empty( $header_image ) ) : ?> with-image<?php endif; ?>">
						<?php get_search_form(); ?>
						</div>
					<?php
						else :
					?>
						<?php get_search_form(); ?>
					<?php endif; ?>
            </li>
        </ul>
    </div>
</div>
<div class="clearfix"></div>
<div id="header"></div>

<div id="wrap">
    <div id="headbar"></div>
	<div id="nav">
        <ul>
            <li><a href="/wordpress/home/" id="home">home</a></li>
            <li><a href="/wordpress/ministries/" id="ministries">ministries</a></li>
            <li><a href="/wordpress/directions/" id="directions">directions</a></li>
            <li><a href="/wordpress/media/" id="media">media</a></li>
        </ul>
    </div>

	<div id="main">