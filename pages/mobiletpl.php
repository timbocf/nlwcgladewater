<!DOCTYPE html>

<?php
  // Copyright 2010 Google Inc. All Rights Reserved.

  $GA_ACCOUNT = "MO-5781743-6";
  $GA_PIXEL = "/ga.php";

  function googleAnalyticsGetImageUrl() {
    global $GA_ACCOUNT, $GA_PIXEL;
    $url = "";
    $url .= $GA_PIXEL . "?";
    $url .= "utmac=" . $GA_ACCOUNT;
    $url .= "&utmn=" . rand(0, 0x7fffffff);
    $referer = $_SERVER["HTTP_REFERER"];
    $query = $_SERVER["QUERY_STRING"];
    $path = $_SERVER["REQUEST_URI"];
    if (empty($referer)) {
      $referer = "-";
    }
    $url .= "&utmr=" . urlencode($referer);
    if (!empty($path)) {
      $url .= "&utmp=" . urlencode($path);
    }
    $url .= "&guid=ON";
    return str_replace("&", "&amp;", $url);
  }
?>


<html>
<head>
<title>New Life Worship Center | Gladewater TX</title>
<meta name="viewport" content="width=320" />
<link rel="stylesheet" type="text/css" href="css/iphone.css" />

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="scripts/script.js"></script>

<script type="text/javascript" src="http://www.google.com/jsapi?key=ABQIAAAA-yQsMThmsZ1RuL2xF-zD2BR1XQHFZtaRkmQXOL3lwqzoKPzWYhS-EgCW57eZ1F9fVXc6y-ecRKzrIA
"></script>
</head>

<body>
<img src="images/logo_mobile2.gif">
<div id="wrap">
    <div id="nav">
        <ul>
            <li><a href="index.php?page=iphone" id="home">home</a></li>
            <li>&nbsp;&nbsp;&nbsp;//&nbsp;&nbsp;&nbsp;</li>
            <li><a href="index.php?page=mobileministries" id="ministries">ministries</a></li>
            <li>&nbsp;&nbsp;&nbsp;//&nbsp;&nbsp;&nbsp;</li>
            <li><a href="index.php?page=mobilemedia" id="mobilemedia">media</a></li>
        </ul>
    </div>
    
    <!-- PAGE CONTENT GOES HERE -->
    <?php echo $page_content ?>
    
    <div id="mobile_or_main">
    	<ul>
        	<li><a href="index.php?page=home" id="fullsite">Full Site</a></li>
            <li>//</li>
            <li><a href="index.php?page=iphone" id="mobilesite">Mobile Site</a></li>
        </ul>
    </div>
</div>

<?php
  $googleAnalyticsImageUrl = googleAnalyticsGetImageUrl();
  echo '<img src="' . $googleAnalyticsImageUrl . '" />';?>

</body>
</html>