<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<style>
	header {
		background: linear-gradient(20deg, #c2c2d6, #a3a3c2);
		font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
		color: black;
		box-shadow: 0 6px 4px -4px rgba(0, 0, 0, .2);
	}
	body {
		font-family: Arial;
		padding: 10px;
		background: #f1f1f1;
  	}
	.logo {
	  	float: left;
		padding: 5px;
	}
	nav {
		float: right;
		padding-right: 3%;
	}
	nav ul {
		margin: 0;
		padding: 0;
	}
	nav li {
		display: inline-block;
		padding: 5px;
	}
	.cont {
		width: 100%;
		max-width: 1024px;
		padding: 15px;
		margin: 0 auto;
}
	.cont:after {
		content: "";
		display: table;
		clear: both;
	}
	a {
		text-decoration: none;
		color: black;
	}
	a:hover {
        font-weight: bold; 
    }
	.card {
		background-color: white;
		padding: 1%;
		margin-top: 20px;
  	}
</style>
</head>
<a href="/main"><header>
<div class="cont"><a href="/main" class="logo">CAMAGRU</a>
    <nav>
      <ul>
	  <?php
        if (!isset($_SESSION['login']) and !isset($_SESSION['password'])) {
                echo "<li><a href='/auth'>Sign In</a></li>";
                echo "<li><a href='/signup'>Sign Up</a>";
            }
        else {
            echo "<li><a href='/main'>{$_SESSION['login']}</a></li>";
            echo "<li><a href='/settings'>Settings</a></li>";
            echo "<li><a href='/auth/signout'>Sign Out</a></li>";
        }
        ?>  
      </ul>
    </nav>
  </div>
</header></a>
<body>
<div class="card">
	<?php include 'application/views/'.$content_view; ?>
	</div>
</body>
</html>