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

$aid = @$_GET['aid'];

$article = get_article($aid);
$smarty->assign('article', $article);

$photo = get_photo($article['pid']);
$smarty->assign('photo', $photo);

$tags = get_articleTags($aid);
$smarty->assign('tags', $tags);

$comments = get_comments($aid);
$smarty->assign('comments', $comments);

$commenters = array();
foreach($comments as $comment) {
	$commenters[] = get_commenter($comment['uid']);
}
$smarty->assign('commenters', $commenters);

$error_msg = @$_GET['error_msg'];
$smarty->assign("error_msg", $error_msg);

$action = @$_GET['action'];

if($action == "comment") {
	$title = $_POST['title'];
	$body =$_POST['body'];
	$date = time();
	$aid = $_POST['aid'];
	$uid = $_POST['uid'];
	
	if (! add_comment($title, $body, $date, $aid, $uid)) {
		$error_msg = "Comment cannot be empty.";
		header("Location: show_article.php?aid=$aid&error_msg=$error_msg");
		exit;	
	} 	
}

$smarty->display('show_article.tpl');
?>