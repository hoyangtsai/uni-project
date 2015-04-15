<?php
require "includes/defs.php";
require "../Smarty/libs/Smarty.class.php";

include_once("analyticstracking.php");

session_start();

$smarty = new Smarty;

//$error_msg = $_GET['error_msg'];
$msg = @$_GET['msg'];

if (isset($_SESSION['id'])) {
	$login = $_SESSION['id'];
	$smarty->assign("login", $login);
}

$smarty->assign("msg", $msg);
$smarty->display('index.tpl');
?>