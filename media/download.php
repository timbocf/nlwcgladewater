<?php
ob_start();

// Error reporting
error_reporting(E_ALL^E_NOTICE);

// Including the connection file
require('../includes/db.php');
require('../includes/functions.php');

if(!mysqli_query($db, 'SELECT * FROM `dl_log`')){
	
	$query = 'CREATE TABLE dl_log (id int primary key auto_increment not null, filename varchar(255), ipaddress varchar(255), datetime varchar(255), browser varchar(255))';
	
	if(!mysqli_query($db, $query)){
		echo 'Could not create table "dl_log" <br />';
	}
}

$dir = '../media/files';

if(!$dir) {
	echo ("There is an error with your file directory!");
}

if(!$_GET['file']) error('Missing parameter!');
if($_GET['file']{0}=='.') error('Wrong file!');

if(file_exists($dir . '/' . $_GET['file'])) {
	
	// If the visitor is not a search engine, count the download
	if(!is_bot()) {
		// Updates times downloaded in database
		mysqli_query($db, "INSERT INTO dl_manager SET filename='" . mysqli_real_escape_string($db, $_GET['file']) . "' ON DUPLICATE KEY UPDATE downloads=downloads+1");
		
		// Logs downloader info
		$ip = $_SERVER['REMOTE_ADDR'];
		date_default_timezone_set('America/Chicago');
		$date = date('Y-m-d H:i:s');
		$browser = ucfirst($ua['platform'].' / '.$ua['name'].' '.$ua['version'].'<br /><br />UserAgent: '.$ua['userAgent']);
		
		mysqli_query($db, "INSERT INTO dl_log (filename, ipaddress, datetime, browser) VALUES ('" . mysqli_real_escape_string($db, $_GET['file'])."', '".$ip."', '".$date."', '".$browser."')");
				
		 // Opens mp3 in new window
		 header("Location: ". $dir . "/" . $_GET['file']);
		 exit;
	}
}else {
	error("<br />This file does not exist!");
	closedir();
}

// Helper functions
function error($str) {
	die($str);
}

function is_bot() {
	// This function checks whether the visitor is a search engine bot
	
	$botlist = array("Teoma", "alexa", "froogle", "Gigabot", "inktomi", "looksmart", "URL_Spider_SQL", "Firefly", "NationalDirectory", "Ask Jeeves", "TECNOSEEK", "InfoSeek", "WebFindBot", "girafabot", "crawler", "www.galaxy.com", "Googlebot", "Scooter", "Slurp", "msnbot", "appie", "FAST", "WebBug", "Spade", "ZyBorg", "rabaz", "Baiduspider", "Feedfetcher-Google", "TechnoratiSnoop", "Rankivabot", "Mediapartners-Google", "Sogou web spider", "WebAlta Crawler", "TweetmemeBot", "Butterfly", "Titturls", "Me.dium", "Twiceler");
	
	foreach($botlist as $bot) {
		if(strpos($_SERVER['HTTP_USER_AGENT'], $bot) !== false) {
			return true;  // is a bot
		}
	}
	
	return false;  // not a bot
}

ob_end_flush();
?>