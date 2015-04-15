<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link href="css/style.css" rel="stylesheet" type="text/css" />

<title>Log In</title>

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

{if $error_msg}
  <p class="alert">{$error_msg}</p>
{/if}

<h2>Enter Username &amp; Password</h2>
<form method="post" action="action.php?action=login">
<table>
<tr><td>Username:</td><td><input type="text" size=30 name="username"></td></tr>
<tr><td>Password:</td><td><input type="password" size=30 name="password"></td></tr>
<tr><td></td><td align="right">Username and Password are case-sensitive.</td></tr>
<tr>
	<td colspan=2 align="right">
    <input type="submit" value="Log in">
    </td>
</tr>
</table>
</form>


{include file="footer.tpl"}

</section>
</div>
</body>
</html>
