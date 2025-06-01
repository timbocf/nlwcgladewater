<?php
require('includes/db.php');

if(!$userIsLoggedIn){
	include('pages/login.php');
}else{
	$sql = mysqli_query($db, 'SELECT * FROM dl_log');
	
	echo '<div class="genericTable"><h2>Downloaded Sermons Report</h2><table>';
	
	while($row = mysqli_fetch_assoc($sql)){
		echo '<tr>';
		foreach($row as $each){
			echo '<td class="genericTable">'.$each.'</td>';
		}
		echo '</tr>';
	}
	echo '</table></div>';
}
?>