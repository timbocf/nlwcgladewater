<?php
$ministry_time = strtotime('1985-01-01 0:00:00');
$time_at_nlwc = strtotime('1999-01-01 0:00:00');
$marriage_time = strtotime('1979-01-01 0:00:00');
?>

<div id="pastors">
    <h2>Meet Our Ministry Team</h2>
    <h3>Lead Pastors</h3>
    <div id="bio">
       	<img src="images/seniorpastors.jpg" alt="Lead Pastors Steven and Rose Goude" />
            <p><strong>Pastors Steven and Rose Goude</strong> have been part of active ministry for <?php echo diff_in_time($ministry_time) ?> years and are entering their <?php echo diff_in_time($time_at_nlwc) ?>th year as pastors of New Life Worship Center.  They are blessed with a wonderful family with two sons and one daughter.  Their children Karen, Steven, and Michael, along with their spouses, also minister in this body of believers.  They are also blessed with seven grandchildren, four girls and three boys.  They are also blessed to share their home with an adorable Maltese puppy, Lacie Brooke.  They celebrated <?php echo diff_in_time($marriage_time) ?> years of marriage last October.</p>
	</div>
</div>
</div>
<div class="clearfix"></div>
<div id="sub"></div>