<?php
//Read HOST, USER, PASSWORD, DATABASE from file
//require "/net/homes/export/student/s2603948/public_html/wp/mysql/mysql.php";

// Show MySQL error
function showerror() {
	die("Error ". mysql_errno() . " : " . mysql_error());
}

/* Open connection and select database. */
function mysql_open() {
	$connection = @ mysql_connect('localhost', 'root', 'rootdbpw') or die("Could not connect");
	mysql_select_db('simpblog', $connection) or showerror();
	return $connection;
}

function signup($username, $password, $real_name, $email) {
	$connection = mysql_open();

	$username = mysql_escape_string(stripslashes($username));
	$password = mysql_escape_string(stripslashes($password));
	$real_name = mysql_escape_string(stripslashes($real_name));
	$email = mysql_escape_string(stripslashes($email));

	$salt = substr($username, 0, 2);
	$encryptedPassword = crypt($password, $salt);

	$insert = "INSERT INTO blog_users VALUES" .
				"(null, '$username', '$encryptedPassword', '$real_name', '$email')";

	$result = mysql_query ($insert, $connection) or showerror();

	mysql_close($connection) or showerror();
}

function login($username, $password) {
	$connection = mysql_open();

	$username = mysql_real_escape_string($username, $connection);
	$password = mysql_real_escape_string($password, $connection);

	$salt = substr($username, 0, 2);
	$encryptedPassword = crypt($password, $salt);

	$query = "SELECT * FROM blog_users" .
           " WHERE username = '$username'" .
           " AND password = '$encryptedPassword'";

	$result = mysql_query ($query, $connection) or showerror();
	$rowcount = mysql_num_rows($result);
	$user = mysql_fetch_array ($result);

	mysql_close($connection) or showerror();

	if ($rowcount == 1) {
		session_start();
		$_SESSION['id'] = $user[0];
		$_SESSION['id'] = array();
		$_SESSION['id'] = $user;
		$msg = "Logged in.";
		//return ($rowcount == 1);
		header("Location: index.php?msg=$msg");
		exit;
	}
	else {
		$error_msg = "User not found.";
		$referer = $_SERVER['HTTP_REFERER'];
		header("Location: $referer?error_msg=$error_msg");
		exit;
	}
}

function create_blog($title, $summary, $username, $date) {
	if (trim($title) == '') {
		return false;
    }

	$title = mysql_escape_string(stripslashes($title));
	$summary = mysql_escape_string(stripslashes($summary));
	$username = mysql_escape_string(stripslashes($username));

	$connection = mysql_open();

	$insert = "INSERT INTO blogs " .
				"VALUES (NULL, '$title', '$summary', '$username',  FROM_UNIXTIME($date))";
	$result = @ mysql_query ($insert, $connection) or showerror();

	mysql_close($connection) or showerror();

	header("Location: show_blogs.php?msg=created");
	exit;
}

function add_comment($title, $body, $date, $aid, $uid) {
	if ($body == '' || !isset($body)) {
		return false;
    }

	$title = mysql_escape_string(stripslashes($title));
	$body = mysql_escape_string(stripslashes($body));

	$connection = mysql_open();

	$insert = "INSERT INTO blog_comments " .
				"VALUES (NULL, '$title', '$body', FROM_UNIXTIME($date), '$aid', '$uid')";
	mysql_query ($insert, $connection) or showerror();

	mysql_close($connection) or showerror();

	$referer = $_SERVER['HTTP_REFERER'];
	header("Location: $referer&msg=added");
	exit;
}

function get_blogs($username) {
	$connection = mysql_open();

	$query = "SELECT * FROM blogs ";
    if ($username) {
    	$username = mysql_escape_string(stripslashes($username));
		$query .= "WHERE owner='$username' ";
    }
    $query .= "ORDER BY bid";

	$result = @ mysql_query ($query, $connection) or showerror();

	$blogs = array();
	while ($row = mysql_fetch_array($result)) {
		$blogs[] = $row;
	}

	mysql_close($connection) or showerror();

	return $blogs;
}

function get_users() {
	$connection = mysql_open();

	$query = "SELECT * FROM blog_users";

	$result = @ mysql_query ($query, $connection) or showerror();

	$users = array();
	while ($row = mysql_fetch_array($result)) {
		$users[] = $row;
	}

	mysql_close($connection) or showerror();

	return $users;
}


function get_commenter($uid) {
	$connection = mysql_open();

	$query = "SELECT * FROM blog_users WHERE uid = $uid";

	$result = @ mysql_query ($query, $connection) or showerror();

	$commenter = mysql_fetch_array($result);

	mysql_close($connection) or showerror();

	return $commenter;
}

//Add a new article
function add_article($headline, $author, $body, $date, $bid, $uid, $pid, $tags) {
	if ($headline == '' || !isset($headline) ||
        $body == '' || !isset($body)) {
		return false;
    }

	$headline = mysql_escape_string(stripslashes($headline));
	$author = mysql_escape_string(stripslashes($author));
	$body = mysql_escape_string(stripslashes($body));

	$connection = mysql_open();

	$insert = "INSERT INTO blog_articles " .
					"VALUES (null, '$headline', '$author', '$body',  FROM_UNIXTIME($date), '$bid', '$uid', '$pid')";
	$result = @ mysql_query ($insert, $connection) or showerror();

	//get the insert article id for adding tags
	$aid = mysql_insert_id();

	add_tags($aid, $tags, $connection);

	mysql_close($connection) or showerror();

	header("Location: show_articles.php?msg=posted");
	exit;
}

function addImage($image, $uid) {
	if($image['size'] == 0)
		return false;

	// process uploaded image file
	if (is_uploaded_file($image['tmp_name']) && $image['size'] > 0) {
		$imagename = addslashes(basename($image['name']));
		$imagedata = addslashes(file_get_contents($image['tmp_name']));
		$imagesize = getimagesize($image['tmp_name']); // an array
		$imagetype = $imagesize['mime'];
		// $imageheight=$imagesize[0]; $imagewidth=$imagesize[1]; // not required
		$imageheightwidth = addslashes($imagesize[3]); // "height=m width=n" string
	}

	$connection = mysql_open();

	$insert = "INSERT INTO blog_photos " .
					"VALUES (null, '$imagedata', '$imagename', '$imagetype', '$imageheightwidth', $uid)";

	$result = @ mysql_query ($insert, $connection) or showerror();

	mysql_close($connection) or showerror();

	$msg = "'$imagename' is successfully uploaded. Now you can use it on Post New Article.";
	header("Location: upload_photo.php?msg=$msg");
	exit;
}

//Add tags
function add_tags($aid, $tags, $connection) {

	$tags = mysql_escape_string(stripslashes($tags));

	 if (trim($tags) == '') return;

	$tags = trim($tags);
	$tags = preg_split("/[\s]*[,][\s]*/", $tags, -1, PREG_SPLIT_NO_EMPTY);

	foreach($tags as $tag_name) {
		$query = "select * from blog_tags where tag_name='$tag_name'";
        $results = mysql_query($query,$connection) or showerror();

		 if (mysql_num_rows($results) == 1)  {
            $tag = mysql_fetch_array($results);
            $tid = $tag['tid'];
        }
		else {
            $query = "insert into blog_tags(tag_name) values ('$tag_name')";
            $results = mysql_query($query,$connection) or showerror();
            # Should check this call succeeded!
            $tid = mysql_insert_id();
        }

		 # If the article is not tagged with that tag, tag it.
        $query = "select * from article_tags " .
					"where aid=$aid and tid=$tid";
        $results = mysql_query($query,$connection) or showerror();

		if (mysql_num_rows($results) != 1) {
            $query = "insert into article_tags values ($aid, $tid)";
			$results = mysql_query($query, $connection) or showerror();
        }

	}
}

function get_articles($uid) {

	$connection = mysql_open();

	$query = "SELECT * FROM blog_articles ";
    if ($uid) {
		$query .= "WHERE uid = $uid ";
    }
    $query .= "ORDER BY aid DESC";

	$result = mysql_query ($query, $connection) or showerror();

	$articles = array();
    while ($row = mysql_fetch_array($result)) {
        $articles[] = $row;
    }
	mysql_close($connection) or showerror();
	return $articles;
}

function get_photos($uid){
	$connection = mysql_open();

	$query = "SELECT * FROM blog_photos WHERE uid = $uid";

	$result = @ mysql_query($query, $connection) or showerror();

	$photos = array();
	while ($row = mysql_fetch_array($result)) {
		$photos[] = $row;
	}
	mysql_close($connection) or showerror();

	return $photos;
}

function get_photo($pid){
	$connection = mysql_open();

	$query = "SELECT * FROM blog_photos WHERE pid = $pid";
	$result = @ mysql_query($query, $connection) or showerror();

	$photo = mysql_fetch_array($result);
	mysql_close($connection) or showerror();
	return $photo;
}

function get_comments($aid) {
	$connection = mysql_open();

	$query = "SELECT * FROM blog_comments WHERE aid = $aid ORDER BY cid";

	$result = mysql_query ($query, $connection) or showerror();

	$comments = array();
    while ($row = mysql_fetch_array($result)) {
        $comments[] = $row;
    }
	mysql_close($connection) or showerror();
	return $comments;
}

function get_blogArticles($bid) {
	$connection = mysql_open();

	$query = "SELECT * FROM blog_articles " .
				"WHERE bid=$bid ORDER BY aid DESC";

	$result = mysql_query ($query, $connection) or showerror();

	$articles = array();
    while ($row = mysql_fetch_array($result)) {
        $articles[] = $row;
    }
	mysql_close($connection) or showerror();
	return $articles;
}

//Get all tags for searching use
function get_tags() {
	$connection = mysql_open();

    $query = "select * from blog_tags";
    $result = mysql_query($query,$connection) or showerror();

	$tags = array();
    while ($row = mysql_fetch_array($result)) {
        $tags[] = $row;
    }
    mysql_close($connection) or showerror();

    return $tags;
}

//Get all tags from a given article id
function get_articleTags($aid) {
	$connection = mysql_open();

    $query = "select t.tid, t.tag_name from article_tags a, blog_tags t " .
					"where a.aid = $aid and a.tid = t.tid";
    $result = mysql_query($query,$connection) or showerror();

	$tags = array();
    while ($row = mysql_fetch_array($result)) {
        $tags[] = $row;
    }
    mysql_close($connection) or showerror();

    return $tags;
}

//Get a specific tag
function get_tag($tag_name) {
	 $connection = mysql_open();

    $query = "SELECT * FROM blog_tags WHERE tag_name='$tag_name'";

    $results = mysql_query($query, $connection) or showerror();
    if (mysql_num_rows($results) == 1) {
        $tag = mysql_fetch_array($results);
    } else {
        $tag = NULL;
    }
    mysql_close($connection) or showerror();

    return $tag;
}

//Retrieve the articles which include with a given tag
function get_tagArticles($tid) {
	$connection = mysql_open();

    $query = "select a.aid, a.headline, a.author, a.post_date " .
             "from blog_articles a, article_tags t " .
             "where t.tid=$tid and a.aid=t.aid";

    $results = mysql_query($query,$connection) or showerror();
    $articles = array();
    while ($row = mysql_fetch_array($results)) {
        $articles[] = $row;
    }
    mysql_close($connection) or showerror();

    return $articles;
}

//Get all of the articles from the database
function search_articles($string) {
	$connection = mysql_open();

	$query = "SELECT * FROM blog_articles ";

	if (trim($string) != '') {
		$string = mysql_escape_string(stripslashes($string));
		$query .= "WHERE headline LIKE '%$string%' OR article_body LIKE '%$string%' ";
  	}
	$query .= "ORDER BY aid DESC";

	$result = @ mysql_query ($query, $connection) or showerror();

	$articles = array();
	while ($row = mysql_fetch_array($result)) {
		$articles[] = $row;
	}

	mysql_close($connection) or showerror();

	return $articles;
}

//Get a whole content of an article by a defined article id
function get_article($aid) {
	$connection = mysql_open();

	$query = "SELECT * FROM blog_articles WHERE aid = $aid";

	$result = @ mysql_query ($query, $connection) or showerror();
	$article = @ mysql_fetch_array ($result);

	foreach ($article as $value) {
		htmlspecialchars($value);
	}

	//$article = str_replace("\n", "<br>", $article);

	mysql_close($connection) or showerror();
	return $article;
}

//Get a specific blog's attributes by a given blog id
function get_blog($bid) {
	$connection = mysql_open();

	$query = "SELECT * FROM blogs WHERE bid = $bid";
	$result = @ mysql_query ($query, $connection) or showerror();

	$blog = @ mysql_fetch_array ($result);

	mysql_close($connection) or showerror();
	return $blog;
}

//Edit an article by a defined article id
function edit_article($aid, $headline, $body, $pid, $tags) {
    if ($headline == '' || !isset($headline) ||
        $body == '' || !isset($body)) {
        return false;
    }
	$headline = mysql_escape_string(stripslashes($headline));
	$body = mysql_escape_string(stripslashes($body));

	$connection = mysql_open();

	//edit time needed?? $epoch = time();

	$update = "UPDATE blog_articles SET headline = '$headline', article_body = '$body', pid = '$pid' WHERE aid = $aid";
	mysql_query ($update, $connection) or showerror();

	# Edit tags for article
    # Delete all tags for this article
	$query = "DELETE FROM article_tags WHERE aid = $aid";
	mysql_query ($query, $connection) or showerror();

    # Add these tags to the article
    add_tags($aid, $tags, $connection);

	# Delete any now unused tags
    deleteUnusedTags($connection);

	mysql_close($connection) or showerror();

	header("Location: show_article.php?msg=edited&aid=$aid");
	exit;
}

//Edit a blog from a given blog id
function edit_blog($title, $summary, $bid) {
	if (trim($title) == '') {
		return false;
    }

	$title = mysql_escape_string(stripslashes($title));
	$summary = mysql_escape_string(stripslashes($summary));

	$connection = mysql_open();

	$update = "UPDATE blogs SET blog_title = '$title', summary = '$summary' WHERE bid = $bid";
	mysql_query ($update, $connection) or showerror();

	mysql_close($connection) or showerror();

	header("Location: show_blog.php?msg=edited&bid=$bid");
	exit;
}

//Delete an article by a defined article id
function del_article($aid) {
	$connection = mysql_open();

	$query = "DELETE FROM blog_articles WHERE aid = $aid";
	mysql_query ($query, $connection) or showerror();

	# Delete references to article from article_tags table
    # (Should happen automatically but doesn't with ISAM tables)
    $query = "delete from article_tags where aid = $aid";
	mysql_query($query,$connection) or showerror();

	//Delete the comments that belong to the deleted article
	$query = "DELETE FROM blog_comments WHERE aid = $aid";
	mysql_query ($query, $connection) or showerror();

	 # Delete any now unused tags
    deleteUnusedTags($connection);

	mysql_close($connection) or showerror();
}

//Delete a blog
//Both articles related to the blog and tags related to the articles will be deleted as well
function del_blog($bid) {
	$connection = mysql_open();

	$query = "SELECT aid FROM blog_articles WHERE bid = $bid";
	$result = @ mysql_query ($query, $connection) or showerror();

	$aids = array();
	while ($row = mysql_fetch_array($result)) {
		$aids[] = $row;
	}

	foreach ($aids as $aid) {
		del_article($aid['aid']);
	}

	$connection = mysql_open();

	$query = "DELETE FROM blogs WHERE bid = $bid";
	mysql_query($query,$connection) or showerror();

	# Delete any now unused tags
    deleteUnusedTags($connection);

	mysql_close($connection) or showerror();
}

/* Delete any now unused tags, using given connection. */
function deleteUnusedTags($connection) {
	$query = "DELETE FROM blog_tags	" .
					"WHERE tid NOT IN (SELECT DISTINCT tid FROM article_tags)";
	mysql_query($query, $connection) or showerror();
}
?>