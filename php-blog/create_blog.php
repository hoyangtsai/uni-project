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

$error_msg = @$_GET['error_msg'];
$smarty->assign("error_msg", $error_msg);

$smarty->display('create_blog.tpl');
?>