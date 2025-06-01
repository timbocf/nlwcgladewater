<!DOCTYPE html>
<html>
<head>
<style type="text/css">
body {font-family: Arial, sans-serif;}
table {
	background: #fff;
	border-spacing:0;
	border: 1px solid #999;
}
thead {
	background:#333;
	color:#fff;
	padding:10px;
	text-decoration:underline;
}
table tr td {
	padding: 10px 20px;
	border-bottom:1px solid #999;
	text-align:left;
}
.oddrow {
	background:#F5F5F5;
}
.marginLeft {
	border-left: 1px solid #999;
	text-align:center;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="scripts/jquery.tablesorter.min.js"></script>
<script>
$(function(){
	$('table tr:odd').addClass('oddrow');
});

$(function() {
     $("#sortedtable").tablesorter({ sortlist: [0,0] });
});	
</script>
</head>
<body>
<table id="sortedtable">
	<thead>
    	<tr>
        	<th>ID</th>
        	<th>Sermon</th>
            <th>Times<br />Downloaded</th>
        </tr>
    </thead>
            
<?php
include 'includes/db.php';

$result = mysqli_query($db, 'SELECT * FROM dl_manager');

while($data = mysqli_fetch_array($result)) {
	
	echo '<tr>';
	echo '<td>' . $data[0] . '</td>';
	echo '<td class="marginLeft">' . $data[1] . '</td>';
	echo '<td class="marginLeft">' . $data[2] . '</td>';
	echo '</tr>';
}
?>
</table>
</body>
</html>