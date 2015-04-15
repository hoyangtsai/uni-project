<?php
require "includes/defs.php";
require "../Smarty/libs/Smarty.class.php";

include_once("analyticstracking.php");

session_start();

$smarty = new Smarty;

if (isset($_SESSION['id'])) {
	$login = $_SESSION['id'];
	$smarty->assign("login", $login);
	
	$uid = $_SESSION['id']['uid'];
	$photos = get_photos($uid);
	$smarty->assign('photos', $photos);
}

$error_msg = @$_GET['error_msg'];
$smarty->assign("error_msg", $error_msg);

$msg = @$_GET['msg'];
$smarty->assign("msg", $msg);

$smarty->display('upload_photo.tpl');
?>