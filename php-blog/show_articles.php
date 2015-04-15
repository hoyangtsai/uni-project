<?php
require "includes/defs.php";
require "../Smarty/libs/Smarty.class.php";

include_once("analyticstracking.php");

session_start();

$smarty = new Smarty;

if (isset($_SESSION['id'])) {
	$uid = $_SESSION['id']['uid'];
	$articles = get_articles($uid);
	$smarty->assign('articles', $articles);
	
	$username = $_SESSION['id']['username'];
	$blogs = get_blogs($username);
	$smarty->assign('blogs', $blogs);
	
	$login = $_SESSION['id'];
	$smarty->assign("login", $login);
}

//$search = $_GET['search_str'];	

//$deleted = $_GET['delete'];
$smarty->display('show_articles.tpl');
?>