<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="css/style.css" rel="stylesheet" type="text/css" />

<title>Welcome Simple Blog</title>

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
    
    <h2>Welcome{if $login}, {$login.real_name}{/if}</h2>
    
    {if $error_msg}
      <p class="alert">{$error_msg}</p>
    {elseif $msg}
      <p class="notice">{$msg}</p>
    {/if}
    
    <p>Welcome to my simple weblog system.</p>
    <p>For a visitor, you may browse all articles  and search for articles by a given keyword or tag from all blogs.</p>
    <p>In order to post comments, it is to sign up a new account. You will have your own blog pages.</p>
    <p>You may have several blogs and add new articles with a photo to one of these blogs.</p>
    <br />
    <br />
    <p style="color:blue">測試導覽 - Username: demo, Password: demo</p>
    <br />
    <p style="color:blue">使用語言 - HTML, CSS, PHP, Mysql, Smarty etc.</p>
    {include file="footer.tpl"}

</section>
</div>
</body>
</html>