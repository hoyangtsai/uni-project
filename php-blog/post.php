<?php
require "includes/defs.php";
require "../Smarty/libs/Smarty.class.php";

include_once("analyticstracking.php");

session_start();

$smarty = new Smarty;

$error_msg = @$_GET['error_msg'];
$smarty->assign("error_msg", $error_msg);

$msg = @$_GET['msg'];
$smarty->assign("msg", $msg);

if (isset($_SESSION['id'])) {
	$login = $_SESSION['id'];
	$smarty->assign("login", $login);
	
	$username = $_SESSION['id']['username'];
	$blogs = get_blogs($username);
	$smarty->assign('blogs', $blogs);
	
	$uid = $_SESSION['id']['uid'];
	$photos = get_photos($uid);
	$smarty->assign('photos', $photos);
}

$smarty->display('post.tpl');
?>