<?php
require("db.php");

$url = $_SERVER['REQUEST_URI'];

$short = substr(md5(time().$url), 0, 5);

if(mysqli_query($db, "INSERT INTO nlwc.url_redirects (short, url) VALUES ('".$short."', '".$url."');")) {
		return;
} else {
	echo "<h1>oops</h1>";
}

$sql = mysqli_query($db, "SELECT * FROM `".$database."`.`url_redirects` WHERE `short`='".mysql_escape_string($short)."' LIMIT 1");

$row = mysqli_fetch_row($sql);

if(!empty($row)) {
	Header("HTTP/1.1 301 Moved Permanently");
	header("Location: ".$row[2]."");
	echo "<h1>it worked</h1>";
} else {
		$html = "Error: cannot find short URL";
}

?>