<?php
include '../includes/db.php';

$ap = $_POST['Associate Pastor'];
$wp = $_POST['Worship Pastor'];
$yp = $_POST['Youth Pastors'];

if(!$_POST['Senior Pastors']){
	echo '<h1>NO DATA WAS SUBMITTED</h1>';
}else{
	if(!$db->query('UPDATE ministries SET content="'.$sp.'" WHERE ministry_name="Senior Pastors"')){
		echo 'there was a problem'.$db->error;
	}
}

header('Location: ../index.php?page=admin');
?>