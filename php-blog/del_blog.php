<?php
require "includes/defs.php";

// Get a blog id
$bid = $_GET['bid'];

// Delete a blog
del_blog($bid);

header("Location: show_blogs.php?delete=deleted");
exit;
?>