<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" type="text/css" href="css/style.css">

<title>Search Articles</title>

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

<h2>Search Articles</h2>

<h3>by keyword</h3>
<form method="get" action="show_all_articles.php" >
	<input type="text" name="keyword" />
	<input type="submit" value="Search" />
</form>

<h3>by tag</h3>
<form method="get" action="show_all_articles.php">
<select name="tag_name">
  {foreach item=tag from=$tags}
    <option value="{$tag.tag_name}">{$tag.tag_name}</option>
  {/foreach}
</select>
<input type="submit" value="Go">
</form>


{include file="footer.tpl"}

</section>
</div>
</body>
</html>
