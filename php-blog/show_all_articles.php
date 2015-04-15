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

$string = @$_GET['keyword'];
$tag_name = @$_GET['tag_name'];

if (! empty($string)) {
	$articles = search_articles($string);
	$smarty->assign("string",$string);
} else if(! empty($tag_name)) {
	$tag = get_tag($tag_name);
	if ($tag) {
		$articles = get_tagArticles($tag['tid']);
	 } else {
		$articles = array(); 
	 }
	 $smarty->assign("tag_name",$tag_name);
} else { 
	$articles = get_articles(NULL);
}

$smarty->assign('articles', $articles);

$smarty->display('show_all_articles.tpl');
?>