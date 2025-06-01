<?php
/**
 * The template for displaying search forms in Twenty Eleven
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>
	<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
        <input type="text" class="textfield" tabindex="10" name="s" id="s" />
        <input type="submit" class="submitbtn" name="submit" id="searchsubmit" value="Search" />
	</form>