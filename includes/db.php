<?php 

echo $_SERVER['SERVER_ADDR'];

if($_SERVER['SERVER_ADDR'] === '198.57.246.220') {

	$database = 'timbocf_nlwc';

	if($_SERVER['SERVER_NAME'] === 'localhost'){
		$db = mysqli_connect("localhost", "root", "tr8283");
	}else{
		$db = mysqli_connect("localhost", "timbocf_wrdp1", "tr092201");
	}

}

if(!$db) {
	// echo 'Error connecting to database.';
	// echo '<h1>Coming Soon!</h1>';
	exit();
}
if(!mysqli_query($db, 'USE timbocf_nlwc')) {
		mysqli_query($db, 'CREATE DATABASE IF NOT EXISTS nlwc');
		exit();
}


?>

<?php 
//$link = mysql_connect('divineconnectionsdes.ipagemysql.com', 'timbocf', 'tr!828333'); 
//if (!$link) { 
//    die('Could not connect: ' . mysql_error()); 
//} 
//echo 'Connected successfully'; 
//mysql_select_db(dl_manager); 
?> 