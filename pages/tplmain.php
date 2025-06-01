<?php ?>

<!DOCTYPE html>
<html><head>
<title><?php echo ucwords($page) ?> // New Life Worship Center, Gladewater TX</title>
<link rel="stylesheet" type="text/css" href="css/general.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/<?php echo $css ?>" media="screen" />
<link rel="stylesheet" type="text/css" href="css/nivo-slider.css" media="screen" />


<script src="scripts/jquery-1.7.2.min.js" type="text/javascript"></script>
<script type="text/javascript" src="scripts/script.js"></script>
<script src="scripts/jquery.nivo.slider.js" type="text/javascript"></script>
</head>
<body>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-5781743-6']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<div id="live_link">
	<a href="index.php?page=live"><img src="images/live_link.png" alt="Live Services" /></a>
</div>

<div id="topbar">
	<div id="topbar_wrap">
    	<!--<span id="mobile_link"><a href="index.php?page=iphone" id="mobile_link">Mobile Site</a></span>-->
    	<a href="http://www.facebook.com/pages/New-Life-Worship-Center-Gladewater/132937660054214" target="_blank"><img src="images/fbicon.png" id="fbicon" /></a>
        <a href="index.php?page=login" id="login">Login</a>
    </div>
</div>
<div class="clearfix"></div>
<div id="header"></div>

<div id="wrap">
    <div id="headbar"></div>
	<div id="nav">
        <ul>
            <li><a href="index.php?page=home" id="home">home</a></li>
            <li><a href="index.php?page=ministries" id="ministries">ministries</a></li>
            <li><a href="index.php?page=directions" id="directions">directions</a></li>
            <li><a href="index.php?page=media" id="media">media</a></li>
        </ul>
    </div>

    <div id="main">
		<?php if($page === "live"){
			include "pages/youversion.php";
		}else{
			include "includes/calendar.php";
		} ?>

		<!-- MAIN RIGHT-SIDE COLUMN -->
        <?php echo $page_content ?>
	</div>
</div>
<div class="clearfix"></div>
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
          <li><a href="index.php?page=home">home</a></li>
          <li>|</li>
          <li><a href="index.php?page=ministries">ministries</a></li>
          <li>|</li>
          <li><a href="index.php?page=media">media</a></li>
        </ul>
      </div>
      <div id="col3"><!--filler--></div>
    </div>
  </div>
</div>
<div class="clearfix"></div>
</body>
</html>