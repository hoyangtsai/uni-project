<?php
require "includes/defs.php";

// Get an article id
$aid = $_GET['aid'];

// Delete an article
del_article($aid);

header("Location: show_articles.php?delete=deleted");
exit;
?>