<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" type="text/css" href="css/style.css">

<title>Browse Articles</title>

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

{if $tag_name}
    <h2>Articles with tag '{$tag_name|escape}'</h2>
{else}
  {if $string}
    <h2>Articles that match keyword '{$string|escape}'</h2>
  {else}
    <h2>Articles</h2>
  {/if}
{/if}


{if (not $articles)}
  <p class="alert">No article found.</p>
{else}
	<ul>
    	{foreach from=$articles item=article}
          	<li>
            <p><a href="show_article.php?aid={$article.aid}">{$article.headline|escape}</a>, posted at {$article.post_date|date_format}<br />
            by {$article.author|escape}</p>
            </li>
       	{/foreach}
</ul>
{/if}

{include file="footer.tpl"}


</section>
</div>
</body>
</html>
