<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link rel="stylesheet" type="text/css" href="css/style.css">

<title>Read Article</title>

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

<h2>Article Detail</h2>

{if (not $article)}
	<p class="alert">Internal error: No article found.</p>
{else}
	{if $edited}
		<p class="notice">Article updated successsfully.</p>
	{/if}

  <p>
  {$article.headline|escape}, posted at {$article.post_date|date_format}
  <br />
  by {$article.author|escape}
  </p>
  <p>&nbsp;</p>
  {if $photo.photo_size != ""}
  	<img src="show_photo.php?pid={$photo.pid}" {$photo.photo_size} alt="{$photo.photo_name}">
    <p>&nbsp;</p>
  {/if}
  
  <p>{$article.article_body|regex_replace:"/[\n]/":"<br>"}</p>
  <p>&nbsp;</p>
  <p>
  Tags:
	{foreach item=tag from=$tags}
  		{$tag.tag_name|escape},
	{/foreach}
  </p>
	{if $article.uid == $login.uid}
        <nav class="codrops-left">
            <a href="edit.php?aid={$article.aid}">Edit Article</a>
            <a href="delete.php?aid={$article.aid}">Delete Article</a>
       	</nav>
	{/if}
    <br />
    <hr />
    
    <a name="comments"><h3>Comments:</h3></a>
    {if (not $comments)}
    	<p class="alert">No Comment. Why not be the first one.</p>
        {else}
        	{foreach from=$comments item=comment}
            <p>&nbsp; </p>
            	<li>
                <p class="comment_title">{$comment.comment_title} </p>
                {foreach from=$commenters item=commenter}
                    {if $comment.uid == $commenter.uid}
                    	{$commenter.real_name} say...
                    {/if}
                {/foreach}
                <p>{$comment.comment_body}</p>
                <p>{$comment.comment_date|date_format:"%B %e, %Y %r"}</p>
                </li><br />
            {/foreach}
    {/if}
    
    {if $login}
    	{include file="comment.tpl"}
    {/if}

{/if}

{include file="footer.tpl"}

</section>
</div>

</body>
</html>
