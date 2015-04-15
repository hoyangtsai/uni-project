<h1>My Blog, Your Blog</h1>

<nav class="codrops-demos">
	<a href="index.php">Home</a>
    <a href="show_all_blogs.php">Browse All Blogs</a>
	<a href="show_all_articles.php">Browse All Articles</a>
	<a href="search.php">Search for Articles</a> 
    {if (not $login)}
    <a href="login.php">Log in</a>
    <a href="signup.php">Sign Up</a>
	{/if}
</nav>