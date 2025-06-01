<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>

	</div><!-- #main -->

	<footer id="colophon" role="contentinfo">

			<?php
				/* A sidebar in the footer? Yep. You can can customize
				 * your footer with three columns of widgets.
				 */
				if ( ! is_404() )
					get_sidebar( 'footer' );
			?>

	</footer><!-- #colophon -->
</div><!-- #page -->

<!-- MY CUSTOM CODE BEGIN -->

<div id="footerBGfix">
  <div id="footer">
    <div id="footer_wrap">
      <div id="col1">
        <ul>
          <li>New Life Worship Center</li>
          <li>401 N Lee Dr</li>
          <li>Gladewater TX 75647</li>
          <li>903-845-8108</li>
          <li>nlwcgladewater@gmail.com</li>
        </ul>
      </div>
      <div id="col2">
        <ul>
          <li><a href="/wordpress/home/">home</a></li>
          <li>|</li>
          <li><a href="/wordpress/ministries/">ministries</a></li>
          <li>|</li>
          <li><a href="/wordpress/media/">media</a></li>
        </ul>
      </div>
      <div id="col3"><!--filler--></div>
    </div>
  </div>
</div>
<div class="clearfix"></div>

<!-- MY CUSTOM CODE END -->

<?php wp_footer(); ?>

</body>
</html>