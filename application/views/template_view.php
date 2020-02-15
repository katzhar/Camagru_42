<html>
<head>
	<link href="../css/style.css" rel="stylesheet">
</head>
<a href="/main"><header id="header_template">
        <a href="/camera"><img id="logo_temp" src="https://i.pinimg.com/originals/2a/f7/0b/2af70b7eb1194dfea457cdc3b386691b.png"></a>
<div class="cont"><a href="/main" class="logo">CAMAGRU</a>
    <nav>
      <ul>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style type="text/css">
   .header { 
        background: #d0d0e1; 
        position: fixed;
        height: 40px;
        width: 99%;
        color: black;
        padding: 5px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        top: 0;
    }
    .logo {
        float: left;
        padding: 12px;
        text-decoration: none;
    }
    nav {
        float: right;
        padding: 5px;
        text-decoration: none;
    }
    nav ul {
        margin: 0;
        padding: 0;
    }
    nav li {
        display: inline-block;
        padding: 5px;
    }
    body {
        /* background: #f1f1f1; */
    }
    .footer { 
       background: #d0d0e1; 
       bottom: 0;
       position: fixed;
       width: 95%;
       text-align: center;
       padding: 10px;
       }
   .layout DIV { 
       float: left; 
       }
   .col1 { 
       background: #f1f1f1; 
       width: 25%; 
       height: 100%;
       }
   .col2 { 
       /* background: white;  */
       width: 680px; 
       text-align: left;
       padding: 40px;
       padding-left: 20%;
    }
   .col3 { 
       background: #f1f1f1; 
       width: 20%; 
       height: 100%;
       }
    #logo_temp {
        width: 30px; 
        height: 25px;
        align-items: center;
    }
    #logo_tmp:hover {
        width: 33px; 
        height: 28px;
    }
    a {
        text-decoration: none;
        color: black;
    }
    a:hover {
        text-decoration: none;
        font-weight: bold;
    }
  </style>
 </head>
<body>
 <div class="header">
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
  <div class="layout">
   <!-- <div class="col1"></div> -->
   <div class="col2"><?php include 'application/views/'.$content_view; ?></div>
   <!-- <div class="col3"></div> -->
  </div>
  <div class="footer"><a href="/camera"><img id="logo_temp" src="https://i.pinimg.com/originals/2a/f7/0b/2af70b7eb1194dfea457cdc3b386691b.png"></a></div>
 </body>
</html>