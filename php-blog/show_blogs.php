<?php
require "includes/defs.php";
require "../Smarty/libs/Smarty.class.php";

include_once("analyticstracking.php");

session_start();

$smarty = new Smarty;

if (isset($_SESSION['id'])) {
	$username = $_SESSION['id']['username'];
	$blogs = get_blogs($username);
	$smarty->assign('blogs', $blogs);
	
	$login = $_SESSION['id'];
	$smarty->assign("login", $login);
}

$smarty->display('show_blogs.tpl');
?>