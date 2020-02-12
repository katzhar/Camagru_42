<html>
<head>
	<meta charset="utf-8">
	<link href="../css/style.css" rel="stylesheet">
</head>
<a href="/main"><header id="header_template">
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
<body id="body_template">
<div class="card">
	<?php include 'application/views/'.$content_view; ?>
	</div>
</body>
</html>