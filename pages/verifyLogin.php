<?php
if($_POST['username'] && $_POST['password']){
	include '../includes/db.php';
	
	$name = $_POST['username'];
	$pass = md5($_POST['password']);
	
	if(!$db->query('SELECT username FROM members WHERE username="'.$name.'" && password="'.$pass.'"')){
		echo '<h1>'.$db->error.'</h1>';
	}else{
		session_start();
		$_SESSION['username'] = $username;
		$page_content = ob_get_clean();
		// header('Location: ../index.php?page=admin');
		include 'admin.php';
	}
}
?>
