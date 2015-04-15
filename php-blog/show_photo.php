<?php
// Return the image from the entry with the given id
require "includes/defs.php";

$pid = $_GET['pid'];

$photo = get_photo($pid);

$data = $photo['photo_data'];
$name = $photo['photo_name'];
$type = $photo['photo_type'];
$size = strlen($data);

header("Content-length: $size");
header("Content-type: $type");
header("Content-Disposition: attachment; filename=$name");
echo $data;
?>