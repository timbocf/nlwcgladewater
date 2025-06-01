<?php
ob_start();

// Error reporting
error_reporting(E_ALL^E_NOTICE);

// Including the connection file
require('../includes/db.php');

$dir = '../media/files';

if(!$dir) {
	echo ("There is an error with your file directory!");
}

if(!$_GET['file']) error('Missing parameter!');
if($_GET['file']{0}=='.') error('Wrong file!');

if(file_exists($dir . '/' . $_GET['file'])) {
	
	// If the visitor is not a search engine, count the download
	if(!is_bot()) {
		mysqli_query($db, "INSERT INTO dl_manager SET filename='" . mysqli_real_escape_string($db, $_GET['file']) . "' ON DUPLICATE KEY UPDATE downloads=downloads+1");
		
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