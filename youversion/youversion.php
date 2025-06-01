<?php
/*
Plugin Name: YouVersion
Plugin URI: http://youversion.com/
Description: Generates a text bubble and links to YouVersion from marked-up scripture references.  Also enables YouVersion as a widget.
Version: 1.053
Author: Scott Gottreu, Brad Murray
Author URI: http://www.treutech.com/

	
    * This program is free software: you can redistribute it and/or modify
    * it under the terms of the GNU General Public License as published by
    * the Free Software Foundation, either version 3 of the License, or
    * (at your option) any later version.
    *
    * This program is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    * GNU General Public License for more details.
    *
    * You should have received a copy of the GNU General Public License
    * along with this program.  If not, see <http://www.gnu.org/licenses/>.
    

*/

class YouVersion
{
	var $count;
	var $bubble;
	var $widget;
	var $highlight;
	var $translation;
	var $text_domain;
    var $db_version;
	var $language;
	
	function YouVersion()
	{
		$this->count = 0;	
		$this->widget = 'false';	
		$this->bubble = 'false';
		$this->highlight = '';
		$this->translation = '';
		$this->language = '';
		$this->text_domain = 'youversion';
        $this->db_version = "1.053";
	}	
	
	function get_count()
	{
		return $this->count;	
	}
	
	function set_count($count)
	{
		$this->count = $count;	
	}
	
	function get_bubble()
	{
		return $this->bubble;	
	}
	
	function set_bubble($bubble)
	{
		$this->bubble = $bubble;	
	}
	
	function get_widget()
	{
		return $this->widget;	
	}
	
	function set_widget($widget)
	{
		$this->widget = $widget;	
	}
		
	function get_highlight()
	{
		return $this->highlight;	
	}
	
	function set_highlight($highlight)
	{
		$this->highlight = $highlight;	
	}
	
	function get_translation()
	{
		return $this->translation;	
	}
	
	function set_translation($translation)
	{
		$this->translation = $translation;	
	}
	
	function get_language()
	{
		return $this->language;	
	}
	
	function set_language($language)
	{
		$this->language = $language;	
	}
	
	function get_textdomain()
	{
		return $this->text_domain;	
	}

     function get_db_version()
	{
		return $this->db_version;	
	}


}

class YouVersion_Verses
{
	var $text = Array();
	var $id = Array();
	var $timestamp = Array();
	
	function YouVersion_Verses($verses)
	{
		foreach ($verses as $verse) {
	        	$this->text[$verse->reference] = $verse->verse_text;
				$this->id[$verse->reference] = $verse->id;
				$this->timestamp[$verse->reference] = $verse->timestamp;
        }
	}	
	
	function get_verse($reference)
	{
		return $this->text[$reference];	
	}
	
	function get_id($reference)
	{
		return $this->id[$reference];	
	}
	
	function get_timestamp($reference)
	{
		return $this->timestamp[$reference];	
	}
	
	function set_verse($reference, $text, $version, $timestamp)
	{
		global $wpdb;
		$wpdb->query( $wpdb->prepare(
	                    "INSERT INTO youversion_verses 
					(reference, verse_text, version, timestamp) VALUES ( %s, %s, %s, %d )", 
                         $reference, $text, $version, $timestamp ) 
                    );
	}
	
	function update_verse($reference, $text, $version, $timestamp, $id)
	{
		global $wpdb;
		$wpdb->query( $wpdb->prepare(
	                    "UPDATE youversion_verses 
						SET reference = '%s', verse_text = '%s', version = '%s', timestamp = %d 
						WHERE id = '%d'", 
                         $reference, $text, $version, $timestamp, $id ) 
                    );
	}
}

global $objYouVersion;

$objYouVersion = new YouVersion();


add_action('init', 'youversion_init', 4);

register_activation_hook(__FILE__, 'youversion_install');

add_action('init', 'widgets_init_youversion', 4);

add_action('get_footer', 'youversion_css', 5);

add_filter('the_content', 'youversion_process', 5);
add_filter('comment_text', 'youversion_process', 5);

add_action('get_footer', 'youversion_js', 5);	

function youversion_init() {
	global $objYouVersion;

	load_plugin_textdomain($objYouVersion->get_textdomain(), PLUGINDIR.'/'.dirname(plugin_basename(__FILE__)).'/lang', dirname(plugin_basename(__FILE__)).'/lang');
	
	$objYouVersion->set_translation(get_option('yv_bibleversion'));
	$objYouVersion->set_language(get_option('yv_language'));
	$objYouVersion->set_highlight(get_option('yv_highlight'));
	$objYouVersion->set_bubble(get_option('yv_bubble'));

	$installed_version = get_option("yv_db_version");
	
	if ($installed_version != $objYouVersion->get_db_version() ) {
		youversion_install();
	}
	add_action('admin_menu', 'youversion_config_page');
		
}

function youversion_config_page() {
	global $objYouVersion;
	
	if ( function_exists('add_submenu_page') ) {
		add_submenu_page('plugins.php', __('YouVersion', $objYouVersion->get_textdomain()), __('YouVersion', $objYouVersion->get_textdomain()), 'manage_options', 'youversion', 'youversion');
	}
}

function youversion_install() {
	global $objYouVersion;
	global $wpdb;

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		
	$objYouVersion->set_translation(get_option('yv_bibleversion'));
	$objYouVersion->set_language(get_option('yv_language'));
	$objYouVersion->set_highlight(get_option('yv_highlight'));
	$objYouVersion->set_bubble(get_option('yv_bubble'));
	
	$translation = $objYouVersion->get_translation();
	
	if (empty($translation)) {
		add_option('yv_bibleversion', 'nasb', 'YouVersion Bible Translation', 'no');
		add_option('yv_language', 'en', 'English', 'no');
		add_option('yv_highlight', 'eeeebb', 'YouVersion Highlight Color', 'no');
		add_option('yv_bubble', 'false', 'YouVersion Bubble', 'no');
	}

	$installed_version = get_option("yv_db_version");

	if( floatval($installed_version) < floatval($objYouVersion->get_db_version()) ) {
		if($installed_version == false) {
			$sql = "CREATE TABLE youversion_verses (
				    id mediumint(9) NOT NULL AUTO_INCREMENT,
				    reference text NOT NULL,
				    verse_text text NOT NULL,
				    version VARCHAR(55) NOT NULL,
	                timestamp BIGINT(20) NOT NULL,
				    PRIMARY KEY id (id)
				    ) CHARSET utf8 COLLATE utf8_unicode_ci ;";
	
			dbDelta($sql);
	          
	        $sql = "CREATE TABLE youversion_books (
	                    id mediumint(9) NOT NULL AUTO_INCREMENT,
	                    json LONGTEXT NOT NULL ,
	                    timestamp BIGINT(20) NOT NULL,
	                    PRIMARY KEY id (id)
	                    ) CHARSET utf8 COLLATE utf8_unicode_ci ;";
	
			dbDelta($sql);
			add_option('yv_db_version', $objYouVersion->get_db_version(), 'YouVersion Database Version', 'no');
		} else {/** @todo Determine why the update section does not run    */
			//$sql = "DROP TABLE youversion_verses;";
			//dbDelta($sql);

			//$sql = "DROP TABLE youversion_books;";
			//dbDelta($sql);

			$sql = "CREATE TABLE youversion_verses (
				    id mediumint(9) NOT NULL AUTO_INCREMENT,
				    reference text NOT NULL,
				    verse_text text NOT NULL,
				    version VARCHAR(55) NOT NULL,
	                timestamp BIGINT(20) NOT NULL,
				    PRIMARY KEY id (id)
				    ) CHARSET utf8 COLLATE utf8_unicode_ci ;";
	
			dbDelta($sql);
	          
	        $sql = "CREATE TABLE youversion_books (
	                    id mediumint(9) NOT NULL AUTO_INCREMENT,
	                    json LONGTEXT NOT NULL ,
	                    timestamp BIGINT(20) NOT NULL,
	                    PRIMARY KEY id (id)
	                    ) CHARSET utf8 COLLATE utf8_unicode_ci ;";
	
			dbDelta($sql);
			update_option( "yv_db_version", $objYouVersion->get_db_version() );
		}
	}
}

function youversion() 
{
	global $objYouVersion;
	?>
	<?php if ( !empty($_POST ) ) : ?>
	<div id="message" class="updated fade"><p><strong><?php _e('Options saved.', $objYouVersion->get_textdomain()) ?></strong></p></div>
	<?php endif; ?>
	
	
	<div class="wrap">
	<h2><?php _e('YouVersion', $objYouVersion->get_textdomain()); ?></h2>
	
	
	<?php
	if (isset($_REQUEST['function'])) {
		call_user_func($_REQUEST['function'], 'function');
	} else {
		youversion_admin();
	}
	
}

function youversion_admin()
{
	global $objYouVersion;

	echo "<form action='" . $_SERVER['PHP_SELF'] . "?page=youversion&function=update_youversion' method='post' >";
			
	echo "<div>";
	
	$yv_versions = get_versions();
	$yv_books = get_books_json();

	echo "<div >";
	echo __('Show Verse Bubble', $objYouVersion->get_textdomain()) . ": <input type=\"checkbox\" name=\"bubble\" value='true' " . (($objYouVersion->get_bubble() == 'true') ? 'Checked=Checked' : '') . "><br>";
	echo "</div>";

	echo "<div>";
	echo __('Bible Version', $objYouVersion->get_textdomain()) . ": <select name='bibleversion'>";

	foreach($yv_versions as $key => $value) {
		if(($objYouVersion->get_bubble() == 'true' && $value["shortcopy"] == '') || $objYouVersion->get_bubble() == 'false') {
			echo "<option value='" . $key . "' ";
			if($objYouVersion->get_translation()== $key) {
				echo "SELECTED='SELECTED'";
			}
			echo ">" . $value["shorttitle"] . "</option>";
		}
	}
	
	echo "</select>";
	echo "</div>";
	
	echo "<div>";
	echo __('Language', $objYouVersion->get_textdomain()) . ": <select name='language'>";

	foreach($yv_books as $key => $value) {
		echo "<option value='{$key}' ";
		if($objYouVersion->get_language()== $key) {
			echo "SELECTED='SELECTED'";
		}
		echo ">{$key}</option>";
	}
	
	echo "</select>";
	echo "</div>";
	
	$iOtherColor = 0;
	
	echo "<div >";
	echo __('Highlight Color', $objYouVersion->get_textdomain()) . ": <select name='highlight' >";

	echo "<option value='#FFFFFF' " . (($objYouVersion->get_highlight() == '#FFFFFF') ? "SELECTED='SELECTED'" : $iOtherColor++) . ">" . __('White', $objYouVersion->get_textdomain()) . "</option>";
	echo "<option value='#666666' " . (($objYouVersion->get_highlight() == '#666666') ? "SELECTED='SELECTED'" : $iOtherColor++) . ">" . __('Light Grey', $objYouVersion->get_textdomain()) . "</option>";
	echo "<option value='#99CCFF' " . (($objYouVersion->get_highlight() == '#99CCFF') ? "SELECTED='SELECTED'" : $iOtherColor++) . ">" . __('Light Blue', $objYouVersion->get_textdomain()) . "</option>";
	echo "<option value='#FFFFCC' " . (($objYouVersion->get_highlight() == '#FFFFCC') ? "SELECTED='SELECTED'" : $iOtherColor++) . ">" . __('Light Yellow', $objYouVersion->get_textdomain()) . "</option>";
	echo "<option value='#CCFFCC' " . (($objYouVersion->get_highlight() == '#CCFFCC') ? "SELECTED='SELECTED'" : $iOtherColor++) . ">" . __('Light Green', $objYouVersion->get_textdomain()) . "</option>";	
	//echo "<option value='Other' " . (($iOtherColor == 5) ? "SELECTED='SELECTED'" : '') . ">" . __('Other', $objYouVersion->get_textdomain()) . "</option>";	
		
	echo "</select> ";
	
	//echo __('Other', $objYouVersion->get_textdomain()) . ": <input type=\"text\" name=\"highlight_other\" size=\"25\" value='" . (($iOtherColor == 5) ? $objYouVersion->get_highlight() : '') . "'> ";
	//echo " * " . __('Color in hexadecimal', $objYouVersion->get_textdomain());
	
	echo "</div>";
	
	echo "<div >";
	echo "<input name='submit_youversion' type='submit' value='  " . __('Update YouVersion Options', $objYouVersion->get_textdomain()) . "  ' />";
	echo "</div >";
	
	echo "<div>";

	echo "
		<strong>Directions for use</strong>
		<p>
		Thanks for downloading the YouVersion Bible plugin.  We have built this plugin for you to customize the way your site intereacts with the Bible.</p>
		<ul>
		    <li>Verse Bubble</li>
		    <li>Direct Link</li>
		    <li>Sidebar Widget</li>
		</ul>
		<strong>Verse Bubble</strong>
		<p>
		This optional verse bubble can be enabled by checking the box at the top of this page.  When checked, it limits the translations to those that are public domain.  Leaving the box unchecked gives you access to any translation available on YouVersion.com.  You will have a direct link to YouVersion even if you don't use the verse bubble.</p>
		<p><strong>How it works:</strong><br/>
		In your post, (using either the Visual or HTML view) use the tags shown below fore each scripture reference.</p>
		<p>
		[youversion]John 3:16[/youversion]
		</p>
		<strong>Sidebar Widget</strong>
		<p>You can enable the YouVersion widget by going to the Design section and then to the Widgets section.  Find the YouVersion widget listed on the left and click \"Add\".  Place the widget where you want it to appear on your sidebar and click \"Save Changes\".</p>
		";
		

	echo "</div>";
	
	echo "</div>";
	echo "</form>";
}

function update_youversion() {
	global $objYouVersion;

	if(isset($_POST['submit_youversion'])) {
		if(!isset($_POST['bubble'])) {
			$_POST['bubble'] = 'false';
		}
		if($_POST['highlight'] == 'Other') {
			if(substr($_POST['highlight_other'], 0, 1) != '#') {
				$_POST['highlight_other'] = '#' . $_POST['highlight_other'];
			}
			$highlight = $_POST['highlight_other'];
		} else {
			$highlight = $_POST['highlight'];
		}
			
		update_option('yv_bibleversion', $_POST['bibleversion']);
		update_option('yv_highlight', $highlight);
		update_option('yv_bubble', $_POST['bubble']);
		update_option('yv_language', $_POST['language']);
			
		$objYouVersion->set_bubble($_POST['bubble']);
		$objYouVersion->set_highlight($highlight);
		$objYouVersion->set_translation($_POST['bibleversion']);
		$objYouVersion->set_language($_POST['language']);
	}
	
	youversion_admin();
}

function youversion_process($text)
{
	global $objYouVersion;

	$yv_books = get_books_json();
		
	$count = substr_count($text, "[youversion]");
	
	if ($count > 0) {
		global $wpdb;

        $yv_db_verses = $wpdb->get_results("SELECT id, reference, verse_text, version, timestamp  
									FROM youversion_verses 
	                    			WHERE version = '" . $objYouVersion->get_translation() . "'");

        $objYV_Verses = new YouVersion_Verses($yv_db_verses);

		$pieces = explode("[youversion]", $text);
		$grep_array = preg_grep("/\[\/youversion\]/", $pieces);
        $IsFeed = get_query_var('feed');  // Determine whether WP is outputting a feed or normal content.

		for($i=0;$i<=count($grep_array);$i++) {
			$start_verse = '';
			$end_verse = '';
			$start_chapter = '';
			$end_chapter = '';
			$book = '';
			
			$scripture[$i] = $grep_array[$i];
			$scripture[$i] = preg_replace("/\n/", '', $scripture[$i]);	
			$scripture[$i] = preg_replace("/\[\/youversion\].*/", '', $scripture[$i]);
		
			if(substr_count($scripture[$i], ":") == 2) {
				$parts = explode("-", $scripture[$i]);
				
				$first = explode(" ", $parts[0]);
				
				for($y=0;$y<count($first)-1;$y++) {
					$book .= $first[$y] . " ";
				}
				$book = trim($book);
				
				$index = count($first)-1;
				
				$start = explode(":", $first[$index]);
				$start_chapter = $start[0];
				$start_verse = $start[1];
				
				$end = explode(":", $parts[1]);
				$end_chapter = $end[0];
				$end_verse = $end[1];
			} else {
				$pieces = explode(":", $scripture[$i]);

				$verse_piece = explode("-", $pieces[1]);
				$start_verse = $verse_piece[0];
				
				if(count($verse_piece)>1) {
					$end_verse = $verse_piece[1];
				} else {
					$end_verse = $start_verse;
				}
				
				$pieces2 = explode(" ", $pieces[0]);
				$piece_count = count($pieces2);
				$start_chapter = $pieces2[$piece_count-1];
				$book = '';
				
				for($y=0;$y<$piece_count-1;$y++) {
					$book .= $pieces2[$y] . " ";
				}
				$book = trim($book);
			}

			$abbrBook = 'fubar';
			$lang = $objYouVersion->get_language();
			
			if(phpversion() < "5.0") {  // PHP4 throws an error on the foreach even though it works fine.
				error_reporting(0);  // So turn off the errors to get past the loop
			}
			
			foreach($yv_books[$lang] as $key => $value){
				if(strtolower($key) == strtolower(str_replace(" ", "", $book)) || strtolower($value) == strtolower($book)) {
					$abbrBook = $key;
					$abbrBook = strtolower($key);
					$abbrBook = ucfirst($abbrBook);

					if(substr($abbrBook, 0, 1) > 0)	{
						$abbrBook = substr($abbrBook, 0, 1) . ucfirst(substr($abbrBook, 1));
					}
					break;
				}
			} 
			if(phpversion() < "5.0") { // PHP4 throws an error on the foreach even though it works fine.
				error_reporting(E_ALL ^ E_NOTICE); // So turn normal error reporting back on. 
			}
			
			$startverse[$i] = "{$abbrBook}.{$start_chapter}.{$start_verse}";

			if($objYouVersion->get_bubble() == 'true') {
				if($end_chapter != '') {
					$end_verse = 200;
				} else {
                    $end_chapter = $start_chapter;
                }
                if($objYV_Verses->get_verse($scripture[$i]) == false || $objYV_Verses->get_timestamp($scripture[$i]) < (time() - 28800)) { // cache for 8 hours) 
				    $yv_selected_verses[$i] = youversion_getverses_api($abbrBook, $start_chapter, $end_chapter, $start_verse, $end_verse);
                    
					if($scripture[$i] != false) {
						if($objYV_Verses->get_verse($scripture[$i]) == false) {
							$objYV_Verses->set_verse($scripture[$i], $yv_selected_verses[$i], $objYouVersion->get_translation(), time());
						} else {
							$objYV_Verses->update_verse($scripture[$i], $yv_selected_verses[$i], $objYouVersion->get_translation(), 
													time(), $objYV_Verses->get_id($scripture[$i]));
						}
					}
                } else {
                    $yv_selected_verses[$i] = $objYV_Verses->get_verse($scripture[$i]);
                }
			}
		}
		
		for($i=0;$i<$count;$i++) {
			$z_index = $objYouVersion->get_count()+2;
			
			$replacement = "<a target='_blank' href='http://www.youversion.com/reader.php?version=" . $objYouVersion->get_translation(). "&startverse=" . $startverse[$i+1] . "' style='display:inline;' " . 
							(($objYouVersion->get_bubble() == 'true') ? "onmouseover='yv_popup(" . $objYouVersion->get_count() . ")'" : '') . ">";
			$text = preg_replace("/\[youversion\]/", $replacement, $text, 1);
			
			$replacement = "</a>";	

			if($objYouVersion->get_bubble() == 'true' && $yv_xml_section != 'false' && $IsFeed == '') {  // If the content is for normal display then allow the bubble.
				$replacement .= "<span style='z-index: $z_index;background-color:" . $objYouVersion->get_highlight() . ";' class='yv_bubble_wrap' id='yv_popover_" . $objYouVersion->get_count() . "'>";
				$replacement .= "<span id=\"ref_yv_bubble\"><strong>" . $scripture[$i+1] . " (" . strtoupper($objYouVersion->get_translation()) . ")</strong></span>";
				$replacement .= "<span id=\"close_yv_bubble\"><a href='javascript:yv_popdown(" . $objYouVersion->get_count() . ")'>" . __('Close', $objYouVersion->get_textdomain()) . "</a></span>";
				$replacement .= "<div id=\"yv_bubble\"><p>";
				$replacement .=	$yv_selected_verses[$i+1];
				$replacement .= "</p>";
				$replacement .= "</div><div id=\"powered_by_yv\"><strong>" . __('Powered by', $objYouVersion->get_textdomain()) . " <a target='_blank' href='http://www.youversion.com'>YouVersion</a></strong></div></span>";
			}
			
			$text = preg_replace("/\[\/youversion\]/", $replacement, $text, 1);
			
			$objYouVersion->set_count($objYouVersion->get_count()+1);
		}
		
	}

	return $text;
}

function youversion_css() {
	echo "<link rel=\"stylesheet\" href=\"" . get_bloginfo('wpurl') . '/' . PLUGINDIR.'/'.dirname(plugin_basename(__FILE__))."/youversion.css\" type=\"text/css\" media=\"screen\" />";
	return $text;
}

function youversion_js() 
{
	global $objYouVersion;
	
	if($objYouVersion->get_bubble() == "true") {
		youversion_js_bubble();	
	}

	if($objYouVersion->get_widget() == "true") {
		youversion_js_widget();	
	}
}

function youversion_js_bubble() 
{
	echo "<script type=\"text/javascript\">
	
		function yv_popup(i) 
		{
			hide_yv_popover();
			var id = \"yv_popover_\"+i
			document.getElementById(id).style.visibility = \"visible\";
		}
		
		function yv_popdown(i) 
		{
			var id = \"yv_popover_\"+i
			document.getElementById(id).style.visibility = \"hidden\";
		}
		
		function hide_yv_popover() {
			var divs = document.getElementsByTagName('span');
			for( var i = 0, div; div = divs[i]; i++ ) {
				if(div.className == 'yv_bubble_wrap') {
					div.style.visibility = \"hidden\";
				}
			}
		}
		hide_yv_popover();
		
	</script>";
}

function youversion_js_widget()
{
		echo "<script type=\"text/javascript\">
	
		var showdate = 0;
		var summary = 1;
		var entries = 10;
	
		function yv_tabs(id) 
		{
			if(id == '' || id == undefined) {
				id = 'yv_search';
			}

			document.getElementById(\"yv_search\").style.display=\"none\";
			document.getElementById(\"yv_dailyreading\").style.display=\"none\";
			document.getElementById(\"yv_contributions\").style.display=\"none\";
			
			document.getElementById(id).style.display = \"block\";
		}
		
		function show_summary(i){
			var div = document.getElementById(\"summary_\"+i);
			div.style.display=\"block\";
			var show_btn = document.getElementById(\"showsummary_\"+i);
			show_btn.style.display=\"none\";
			var hide_btn = document.getElementById(\"hidesummary_\"+i);
			hide_btn.style.display=\"inline\";
		}
	
		function hide_summary(i){
			var div = document.getElementById(\"summary_\"+i);
			div.style.display=\"none\";
			var show_btn = document.getElementById(\"showsummary_\"+i);
			show_btn.style.display=\"inline\";
			var hide_btn = document.getElementById(\"hidesummary_\"+i);
			hide_btn.style.display=\"none\";
		}

		yv_tabs();
		
	</script>";
}

function youversion_fetch_url($url,$method="GET",$params="") {
	require_once( ABSPATH . 'wp-includes/class-snoopy.php');
	$snoopy = new Snoopy();
    $snoopy->maxlength = 1000000;  // Increased maxlength from 500000

	$result = $snoopy->fetch($url);
	if(!$result) return false;
	else return $snoopy->results;
}

function get_versions() 
{
	$versions = wp_cache_get('youversion_versions');
	if($versions == false) {
		$url = 'http://youversion.com/js/versions_wp.json';
          $data = youversion_fetch_url($url);
          if(!$data) return false;
		$versions = youversion_json_decode($data);
		if(!$versions) return false;
		wp_cache_set('youversion_versions', $versions, '', 14400); // cache for 4 hours
	}
	return $versions;
}

function get_books_json() 
{
	global $wpdb;
	
	$books = wp_cache_get('youversion_books');
	if($books == false) {
		$book = $wpdb->get_results("SELECT id, json, timestamp  
									FROM youversion_books");

		 // if($books[0]->timestamp > (time() - 28800)) { // cache for 8 hours
			  //$data = $books[0]->json;
		 // } else {
		      $url = 'http://youversion.com/js/books.json';
		      $data = youversion_fetch_url($url);
			 
		  	  if(!$book[0]->id) {
		  	  	  $wpdb->query($wpdb->prepare("INSERT INTO youversion_books 
							  				(json, timestamp) VALUES (%s, %d)",
											$data, time()));
		  	  } else {
			 	  $wpdb->query($wpdb->prepare("UPDATE youversion_books 
							  				SET json = %s, timestamp = %d 
											WHERE id = %d",
											$data, time(), $book[0]->id));
			  }
		      
		 // }
          
          if(!$data) {
               return false;
          }
          $books = youversion_json_decode($data);
          
          if(!$books) {
               return false;
          }
          wp_cache_set('youversion_books', $books, '', 28800); // cache for 8 hours
	}
	return $books;
}

function youversion_json_decode($json) {
	// use json_decode from php >= 5.2 if available
	if (function_exists('json_decode')) {
		return json_decode($json,true);
	}
	if (!class_exists('Services_JSON')) {
		require_once('services_json.php');
	}

	$results = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
	
	return $results->decode($json);
}

function youversion_getverses_api($book,$start_chapter,$end_chapter,$start_verse,$end_verse) {
	$versekey = 'youversion_verses_' . md5($book . $start_chapter . $start_verse . $end_chapter . $end_verse);
	$results = wp_cache_get($versekey);
	if($results == false) {
 		global $objYouVersion;

          if($start_verse == false) {
               $start_verse = 1;
          }
          if($start_chapter == $end_chapter) {
               $total_verses = ($end_verse - $start_verse) + 1;
               if($total_verses > 4) {
                    $total_verses = 4;
               }  
          } else {
               $total_verses = 4;
               $stop_verse = $end_verse;
          }
		
		$more_tag = " [<a target='_blank' href='http://www.youversion.com/reader.php?version=" . $objYouVersion->get_translation(). "&startverse={$book}.{$start_chapter}'>" . __('more', $objYouVersion->get_textdomain()) . "</a>]";
	
          $version = $objYouVersion->get_translation();
		$url = "http://bible.api.youversion.com/verse/json/text/{$version}/{$book}.{$start_chapter}.{$start_verse}";
		$result = youversion_fetch_url($url);
		if($result) {
			$data = youversion_json_decode($result);
			if(!$data) return false;
			$vhtml = '';
			if(empty($data['response']['code']) || !($data['response']['code'] == 200 || $data['response']['code'] == 202)) return false;
			$vset = $data['response']['data'][0]['items'];

               for($i = 0; $i < $total_verses; $i++) {
                    $ref = explode(".", $vset[$i]['osis']);
				$vhtml .= " <sup>" . $ref[2] . "</sup>" . $vset[$i]['text'];
			}
               $vhtml .= $more_tag;
			$vhtml = str_replace("\n", "", $vhtml);
			wp_cache_set($versekey, $vhtml, '', 86400); // cache for 24 hours
			return $vhtml;
		} else {
			return false;
		} 
	} else {
          return $results;
     }
}

function widget_youversion() 
{
	global $objYouVersion;
	$objYouVersion->set_widget('true');	
	
	$before_widget = '<li id="youversion" class="widget widget_youversion">';
	$after_widget = "</li>\n";
	$before_title = '<h2 class="widgettitle">';
	$after_title = "</h2>\n";

	$contributions = youversion_contributions();
	$daily_reading = youversion_dailyreading();
		
	echo $before_widget; 
	echo $before_title;
	
	echo 'YouVersion';
	             
	echo $after_title; 

?>
<!--	
	<div id="branding">
		<img src="http://youversion.com/img/logo-yv-igoogle.png" alt="YouVersion" />
	</div>-->
	<div id="yv_widget">
		<div id='yv_tabs'>
			<ul>
			<li><a  onclick="yv_tabs('yv_search');"><?php _e('Search', $objYouVersion->get_textdomain()); ?></a></li>
			<li><a  onclick="yv_tabs('yv_dailyreading');"><?php _e('Daily Reading', $objYouVersion->get_textdomain()); ?></a></li>
			<li><a  onclick="yv_tabs('yv_contributions');"><?php _e('Contributions', $objYouVersion->get_textdomain()); ?></a></li>
			</ul>
		</div>
		<div id="yv_dailyreading" class="content_block" >
			<div><strong class='content_title'><?php _e('Daily Reading', $objYouVersion->get_textdomain()); ?></strong></div>
				<?php echo $daily_reading; ?>
		</div>
		<div id="yv_contributions" class="content_block" >
			<div><strong class='content_title'><?php _e('Recent Contributions', $objYouVersion->get_textdomain()); ?></strong></div>
			<?php echo $contributions; ?>
		</div>
		<div id="yv_search" class="content_block" >
			<strong class="content_title"><?php _e('Look up Verse or Keyword in the Bible', $objYouVersion->get_textdomain()); ?></strong>
			<form target="_blank" action="http://www.youversion.com/results.php" method="post">
			<input type="text" name="s2" style="width:150px" />
			<button style="width:80px;"><?php _e('Search', $objYouVersion->get_textdomain()); ?></button>
			</form> 
		</div>
	</div>


<?php	
   echo $after_widget;
   
}

function widgets_init_youversion() {
	register_sidebar_widget('YouVersion', 'widget_youversion');
}

function youversion_contributions() {
	$results = wp_cache_get('youversion_contributions');
	if($results == false) {

		$results = '';
		$summary = false;
		$js_str = youversion_fetch_url("http://api.feedburner.com/format/1.0/JSON?uri=yv/recentcontribs");
		//error_log($js_str);
		$json = youversion_json_decode($js_str);
		if(!$json) return false;
		
		$items = $json['feed']['items'];
		$length = (sizeof($items) < 8 ? sizeof($items) : 7);
		for($i = 0; $i < $length; $i++) {
			// find the creator, since the json feed doesn't have it		
			$matched = preg_match("|www.youversion.com/user/([a-zA-Z0-9\-_]+)|", $items[$i]['body'], $matches);
			if($matched) $creator = $matches[1];
			else $creator = false;
			
			$results .=  "<li class='contrib_entry'>";
			
			$results .=  "<a target='_blank' href='" . $items[$i]['link'] . "' class='contrib_title'>";
			$results .= str_replace("\\", "", $items[$i]['title']) . "</a>";
			
			if($creator) { 
				$results .=  "<span style='font-size:10px;color:#aaa'> by </span> ";
				$results .= "<a target='_blank' href='http://youversion.com/user/" . $creator . "' class='username'>";
				$results .= $creator . "</a>";
			}
			//$results .=  "<span class='btn show' id='showsummary_$i' onclick='show_summary($i);return false;'>Preview</span>";
	
			if ($summary==TRUE) {
				$results .=  "<div class='preview' id='summary_$i' style='display:none;'>";
				$results .=  "<span class='btn hide' id='hidesummary_$i' onclick='hide_summary($i);return false;' style='display:none;'>Hide</span>";
				$results .=  "<a class='preview_title' target='_blank' href='" . $items[$i]['link'] . "'>";
				$results .= str_replace("\\\"", "\"", $items[$i]['title']) . "</a>";
				$results .=  "</div>";
			}
			$results .=  "</li>";
			wp_cache_set('youversion_contributions', $results, '', 7200); // cache for 2 hours
		}
	}
	return $results;

}

function youversion_dailyreading()
{
	$results = wp_cache_get('youversion_dailyreading');
	if($results == false) {
		$results = '';
		$js_str = youversion_fetch_url("http://api.feedburner.com/format/1.0/JSON?uri=yv/1yearbible");
		$json = youversion_json_decode($js_str);
		if(!$json) return false;
		
		$items = $json['feed']['items'];
	
		$results .=  "<div class='yv_daily_reading'>";
		// for some reason, feedburner seems to double-escape some things...	
		$results .=  str_replace("\\\"", "\"", $items[0]['body']);
		//error_log($items[0]['body']);
		$results .=  "</div>";
		$results = str_replace("\n", '', $results);
		wp_cache_set('youversion_dailyreading', $results, '', 7200); // cache for 2 hours
	}
	return $results;
}


?>
