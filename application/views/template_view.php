<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="../css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 </head>
<body>
 <div class="header">
     <div class="inner">
         <div class="header_wrapper">
             <div class="logo"><a href="/main">CAMAGRU</a></div>
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
     </div>
 </div>
   <?php include 'application/views/'.$content_view; ?>
 </body>
</html>