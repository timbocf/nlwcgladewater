<?php
$allowed_pages = ['home', 'ministries', 'directions', 'media'];
$page = isset($_GET['page']) && in_array($_GET['page'], $allowed_pages) ? $_GET['page'] : 'home';
switch ($page) {
    case 'ministries':
        $css = 'ministries.css';
        break;
    case 'directions':
        $css = 'directions.css';
        break;
    case 'media':
        $css = 'media.css';
        break;
    default:
        $css = 'home.css';
        break;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>New Life Worship Center, Gladewater TX</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="css/general.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/<?php echo $css ?>" media="screen" />
<link rel="stylesheet" type="text/css" href="css/nivo-slider.css" media="screen" />

<script src="scripts/jquery-1.7.2.min.js" type="text/javascript"></script>
<script type="text/javascript" src="scripts/script.js"></script>
<script src="scripts/jquery.nivo.slider.js" type="text/javascript"></script>
<script src="scripts/jquery.tablesorter.js" type="text/javascript"></script>
<script>$(document).ready(function(){$("#mediatbl").tablesorter({headers:{2:{sorter:"shortDate"}},});});</script>
<!-- Bootstrap JS Bundle (with Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoA6VKHr7Wl9EXeU6e1B1r6U6e1B1r6U6e1B1r6U6e1B1r6" crossorigin="anonymous"></script>
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

<div id="topbar">
	<div id="topbar_wrap">
    	<a href="http://www.facebook.com/pages/New-Life-Worship-Center-Gladewater/132937660054214" target="_blank"><img src="images/fbicon.png" id="fbicon" /></a>
    </div>
    <nav id="nav">
        <ul>
            <li><a href="index.php?page=home" id="home">home</a></li>
            <li><a href="index.php?page=ministries" id="ministries">ministries</a></li>
            <li><a href="index.php?page=directions" id="directions">directions</a></li>
            <li><a href="index.php?page=media" id="media">media</a></li>
        </ul>
    </nav>

    <div id="main">
    <!-- Page content will be included here -->
    <?php
    include "pages/{$page}.php";
    ?>
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