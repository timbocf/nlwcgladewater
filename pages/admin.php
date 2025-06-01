<?php
require('includes/db.php');
require('admin/access.php');

if(!userIsLoggedIn()){
	include('pages/admin/login.php');
}else{
	include('pages/admin/reports.php');
	include('pages/admin/logout.php');
}
?>