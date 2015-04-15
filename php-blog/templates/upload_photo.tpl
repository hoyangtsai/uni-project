<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link rel="stylesheet" type="text/css" href="css/style.css">

<title>Upload Photo</title>

</head>

<body>
<div class="container">
<div class="header">
    <a href="../index.html"><strong>&laquo; Back to Main Menu</strong></a>
    <span class="right">
    </span>
    <div class="clr"></div>
</div>
<section class="main">

{include file="header.tpl"}
{if $login}
{include file="user_header.tpl"}
{/if}

<h2>Upload Photo</h2>

{if $error_msg}
  <p class="alert">{$error_msg}</p>
{/if}

<form method="post" action="action.php?action=upload_photo" enctype="multipart/form-data">
<table>
<tr><td align="right"><input type="file" name="imagefile" size="30"></td></tr>
<tr>
	<td colspan=2 align="right">
    <input type="hidden" name="uid" value="{$login.uid}">
    <input type="hidden" name"MAX_FILE_SIZE" value="32768">
    <input type="submit" value="Upload">
    </td>
</tr>
</table>
</form>
<br />

{if $msg}
	<hr />
  <p class="notice">{$msg}</p>
{/if}

{include file="footer.tpl}

</section>
</div>
</body>
</html>
