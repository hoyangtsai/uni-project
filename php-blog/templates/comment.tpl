<br />
<hr>
{if $error_msg}
  <p class="alert">{$error_msg}</p>
{/if}
<h3>Leave a Comment</h3>
<form method="post" action="show_article.php?aid={$article.aid}&action=comment">
<table>
<tr><td>Title:</td><td><input type="text" size=40 name="title"></td></tr>
<tr><td valign="top">Comment:</td>
	<td colspan=2><textarea rows=8 cols=50 name="body"></textarea></td>
</tr>
<tr>
	<td colspan=2 align="right">
    <input type="hidden" name="aid" value="{$article.aid}">
    <input type="hidden" name="uid" value="{$login.uid}">
	<input type="reset" value="Reset">
    <input type="submit" value="Post">
    </td>
</tr>
</table>
</form>