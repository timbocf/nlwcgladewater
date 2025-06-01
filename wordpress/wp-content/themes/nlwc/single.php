<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

<div id="calendar">
    <div id="events">
        <iframe src="<?php bloginfo("template_url") ?>/restylegc/restylegc.php?title=NLWC%20Event%20nlwcCalendar&amp;showTitle=0&amp;showNav=0&amp;showDate=0&amp;showPrint=0&amp;showTabs=0&amp;showCalendars=0&amp;showTz=0&amp;mode=AGENDA&amp;height=265&amp;wkst=1&amp;src=nlwcgladewater%40gmail.com&amp;src=en.usa%23holiday%40group.v.calendar.google.com&amp;ctz=America%2FChicago" style=" border-width:0 " width="304" height="264" frameborder="0" scrolling="no"></iframe>
    </div>
    <a href="/wordpress/uncategorized/calendar/"><img src="<?php bloginfo("template_url") ?>/images/calendar.png" /></a> 
</div>

		<div id="primary">
			<div id="content" role="main" class="content box">

				<?php while ( have_posts() ) : the_post(); ?>

					<!--<nav id="nav-single">
						<!--<h3 class="assistive-text"><?php //_e( 'Post navigation', 'twentyeleven' ); ?></h3>-->
						<!--<span class="nav-previous"><?php //previous_post_link( '%link', __( '<span class="meta-nav">&larr;</span> Previous', 'twentyeleven' ) ); ?></span>-->
						<!--<span class="nav-next"><?php //next_post_link( '%link', __( 'Next <span class="meta-nav">&rarr;</span>', 'twentyeleven' ) ); ?></span>
					</nav>--><!-- #nav-single -->

					<?php get_template_part( 'content', 'single' ); ?>

					<?php comments_template( '', true ); ?>

				<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary -->
        
<div class="clearfix"></div>
<div class="subfix">
	<img src="<?php bloginfo('template_url') ?>/images/subBG.png" />
</div>

<?php get_footer(); ?>
