<?php 

function searchresults() {
require 'includes/db_connect.php';

$sql = "SELECT * FROM searchengine WHERE pagedata LIKE '%$_GET[term]%'";

if (!$result = mysqli_query($db, $sql))
{
	echo mysqli_error($db);
}

while($row = mysqli_fetch_array($result)) 
{
	$list = "<ul>";
	$list .= "<li><a href='$row[pageurl]' target='_blank'>$row[title]</a></li>";
	$list .= "</ul>";
	
	echo $list;
}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>New Life Worship Center // Gladewater TX</title>
<link rel="stylesheet" type="text/css" href="general.css" media="screen" />
<link rel="stylesheet" href="nivo-slider.css" type="text/css" media="screen" />

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
<script src="jquery.nivo.slider.js" type="text/javascript"></script>

<script type="text/javascript">
	function loadCalendar()
	{
		var load = window.open("calendar.php");
	}
</script>

<script type="text/javascript">
$(window).load(function() {
    $('#slider').nivoSlider();
});
</script>

<script type="text/javascript" src="http://www.google.com/jsapi?key=ABQIAAAA-yQsMThmsZ1RuL2xF-zD2BR1XQHFZtaRkmQXOL3lwqzoKPzWYhS-EgCW57eZ1F9fVXc6y-ecRKzrIA
"></script>
</head>

<body>
<div id="topbar">
	<div id="topbar_wrap">
    	<span id="mobile_link"><a href="iphone.php" id="mobile_link">Mobile Site</a></span>
    	<a href="http://www.facebook.com/pages/New-Life-Worship-Center-Gladewater/132937660054214" target="_blank"><img src="images/fbicon.png" id="fbicon" /></a>
    	<div id="search"><?php include 'searchform.php' ?></div>
    </div>
</div>
<div class="clearfix"></div>
<div id="header"></div>
<div id="wrap">
    <div id="headbar"></div>
    <div id="nav">
        <ul>
            <li><a href="index.php" id="home">home</a></li>
            <li><a href="ministries.php" id="ministries">ministries</a></li>
            <li><a href="directions.php" id="directions">directions</a></li>
            <li><a href="media.php" id="media">media</a></li>
        </ul>
    </div>
    <div id="main">
        <div id="calendar"> 
            <div id="events"> 
                    <iframe src="restylegc/restylegc.php?title=NLWC%20Event%20Calendar&amp;showTitle=0&amp;showNav=0&amp;showDate=0&amp;showPrint=0&amp;showTabs=0&amp;showCalendars=0&amp;showTz=0&amp;mode=AGENDA&amp;height=265&amp;wkst=1&amp;src=nlwcgladewater%40gmail.com&amp;src=en.usa%23holiday%40group.v.calendar.google.com&amp;ctz=America%2FChicago" style=" border-width:0 " width="304" height="264" frameborder="0" scrolling="no"></iframe>
            </div> 
            	<a href="calendar.php"><img src="images/calendar.png" /></a> 
            </div>
        <div id="results">
        	<h1>Search Results</h1>
            <?php searchresults() ?>
        </div>
    </div>
    <div class="clearfix"></div>
    <div id="sub">
        <div id="subBGfix"></div>
    </div>
</div>
<div class="clearfix"></div>
<?php include 'includes/footer.php' ?>
<div class="clearfix"></div>
</body>
</html>