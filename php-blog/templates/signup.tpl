<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link rel="stylesheet" type="text/css" href="css/style.css">

<title>Signning Up</title>

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

<h2>Sign Up</h2>

{if $error_msg}
  <p class="alert">{$error_msg}</p>
{/if}

<form method="post" action="action.php?action=signup">
<table>
<tr><td>Username:</td><td><input type="text" size=40 name="username"></td></tr>
<tr><td>Password:</td><td><input type="password" size=40 name="password"></td></tr>
<tr><td>Real Name:</td><td><input type="text" size=40 name="real_name"></td></tr>
<tr><td>Email:</td><td><input type="text" size=40 name="email"></td></tr>
<tr>
	<td colspan=2 align="right">
	<input type="reset" value="Reset">
    <input type="submit" value="Sign Up">
    </td>
</tr>
</table>
</form>


{include file="footer.tpl"}

</section>
</div>
</body>
</html>