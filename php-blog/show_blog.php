<?php
require "includes/defs.php";
require "../Smarty/libs/Smarty.class.php";

include_once("analyticstracking.php");

session_start();

$smarty = new Smarty;

if (isset($_SESSION['id'])) {
	$login = $_SESSION['id'];
	$smarty->assign("login", $login);
}

$bid = $_GET['bid'];

$blog = get_blog($bid);
$smarty->assign('blog', $blog);

$articles = get_blogArticles($bid);
$smarty->assign('articles', $articles);

$smarty->display('show_blog.tpl');
?>