<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link rel="stylesheet" type="text/css" href="css/style.css">

<title>Browse Blogs</title>

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

<h2>Blogs</h2>

{if (not $blogs)}
  <p class="alert">No blog found.</p>
{else}
	<ul>
    	{foreach from=$blogs item=blog}
        	<li>
            <p>
            <a href="show_blog.php?bid={$blog.bid}">{$blog.blog_title|escape}</a>, created at {$blog.created_date|date_format}<br />
            {foreach from=$users item=user}
            	{if $blog.owner == $user.username}
            		by {$user.real_name|escape}<br />
                {/if}
            </p>
            {/foreach}
            <p>&nbsp;</p>
            <p>{$blog.summary|regex_replace:"/[\n]/":"<br>"}</p>
            <p>&nbsp;</p>
            </li>
    	{/foreach}
	</ul>
{/if}

{include file="footer.tpl"}


</section>
</div>
</body>
</html>