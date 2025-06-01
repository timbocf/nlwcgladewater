<?php
if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') || strpos($_SERVER['HTTP_USER_AGENT'], 'iPod')){
	include("mobilemedia.php");
}else{
	include("media_main.php");
}
?>