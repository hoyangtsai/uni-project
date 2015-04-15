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
$smarty->assign('error_msg', $error_msg);

$aid = @$_GET['aid'];
$article = get_article($aid);
$smarty->assign('article', $article);

$tags = get_articleTags($aid);
$smarty->assign('tags', $tags);

$smarty->display('edit.tpl');
?>