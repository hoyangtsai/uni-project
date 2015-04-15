<?PHP
session_start();
$msg = "Logged out.";
session_destroy();
header("Location: index.php?msg=$msg");
exit;
?>