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

$blogs = get_blogs(NULL);
$smarty->assign('blogs', $blogs);

$users = get_users();
$smarty->assign('users', $users);

$smarty->display('show_all_blogs.tpl');
?>