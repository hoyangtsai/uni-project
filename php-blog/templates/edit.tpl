<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link rel="stylesheet" type="text/css" href="css/style.css">

<title>Edit The Article</title>

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

{include file="header.tpl}
{if $login}
{include file="user_header.tpl"}
{/if}

<h2>Edit Article</h2>

{if $error_msg}
  <p class="alert">{$error_msg}</p>
{/if}

<form method="post" action="action.php?action=edit">
<table>
<tr><td>Photo:</td>
<td>
<select name="pid">
	<option value="" selected="selected"></option>
  {foreach item=photo from=$photos}
    <option value="{$photo.pid}">{$photo.photo_name}</option>
  {/foreach}
</select>
</td>
</tr>
<tr><td>Headline:</td><td><input type="text" size=40 name="headline" value="{$article.headline}"></td></tr>
<tr><td valign="top">Content:</td>
	<td colspan=2><textarea rows=12 cols=60 name="body">{$article.article_body}</textarea></td>
</tr>
<tr>
<td>Tags:</td>
<td><input type="text" size=40 name="tags" value="{foreach item=tag from=$tags}{$tag.tag_name|escape}, {/foreach}">(separate tags by comma)</td>
</tr>
<tr>
	<td colspan=2 align="right">
    <input type="hidden" name="aid" value="{$article.aid}">
    <input type="submit" value="Update">
  </td>
</tr>
</table>
</form>


{include file="footer.tpl"}

</section>
</div>
</body>
</html>