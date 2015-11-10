<?php
require "includes/defs.php";

$action = $_GET['action'];

if ($action == "create_blog") {
    $title = $_POST['title'];
	$summary = $_POST['summary'];
	$username = $_POST['username'];
	$date = time();

	if (! create_blog($title, $summary, $username, $date)) {
		$error_msg = "Title cannot be empty.";
		header("Location: create_blog.php?error_msg=$error_msg");
		exit;
	}
}

if ($action == "post") {
	$headline = $_POST['headline'];
	$author = $_POST['author'];
	$body = $_POST['body'];
	$date = time();
	$bid = $_POST['bid'];
	$uid = $_POST['uid'];
	$tags = $_POST['tags'];
	$pid = 0;
	if ($pid != '' && isset($pid)) {
		$pid = $_POST['pid'];
	}

	//check if they are empty, show error message and do not proceed ahead
	if  (! add_article($headline, $author, $body, $date, $bid, $uid, $pid, $tags)) {
		$error_msg = "Headline and Content are required.";
		header("Location: post.php?error_msg=$error_msg");
		exit;
	}
}

if ($action == "edit") {
    $aid = $_POST['aid'];
	$headline = $_POST['headline'];
	$body = $_POST['body'];
	$tags = $_POST['tags'];
	$date = time();
	$pid = 0;
	if ($pid != '' && isset($pid)) {
		$pid = $_POST['pid'];
	}

	//check if they are empty, show error message and do not proceed ahead
	if  (! edit_article($aid, $headline, $body, $pid, $tags)) {
		$error_msg = "Headline and Content cannot be empty.";
		header("Location: edit.php?aid=$aid&error_msg=$error_msg");
		exit;
	}
}

if ($action == "edit_blog") {
	$bid = $_POST['bid'];
    $title = $_POST['title'];
	$summary = $_POST['summary'];
	$date = time();

	if (! edit_blog($title, $summary, $bid)) {
		$error_msg = "Title cannot be empty.";
		header("Location: edit_blog.php?bid=$bid&error_msg=$error_msg");
		exit;
	}
}

if ($action == "upload_photo") {
	$image = $_FILES['imagefile'];
	$uid = $_POST['uid'];

	if (! addImage($image, $uid)) {
		$error_msg = "No photo selected.";
		header("Location: upload_photo.php?error_msg=$error_msg");
		exit;
	}
}

if ($action == "signup") {
    $username = $_POST['username'];
	$password = $_POST['password'];
	$real_name = $_POST['real_name'];
	$email = $_POST['email'];
	if(empty($username) || empty($password) || empty($real_name) || empty($email)) {
		$error_msg = "All fields are required.";
		header("Location: signup.php?error_msg=$error_msg");
		exit;
	}
	else {
		signup($username, $password, $real_name, $email);
		$msg = "Signed up successfully.";
		header("Location: index.php?msg=$msg");
		exit;
	}
}

if ($action == "login") {
	$username = $_POST['username'];
	$password = $_POST['password'];
	if(empty($username) || empty($password)) {
		$error_msg = "Username and Password cannot be empty.";
		header("Location: login.php?error_msg=$error_msg");
		exit;
	} else {
		login($username, $password);
	}
}

?>