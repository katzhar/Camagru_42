<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/style.css" rel="stylesheet">
    <title>Camagru | Log In</title>
</head>
    <style>
        a {
            text-decoration: none;
            color: rgb(82, 82, 82);
        }
    </style>
    <body id="body_auth">
      <div id="container_auth"> 
      <div id="one"><a href="/main">CAMAGRU</a><br><br>
            <form id="form_auth" method="post" action="/auth/login">
            <input type="text" name="login" placeholder="login" value="" required="required"><br><br>
            <input type="password" name="password" placeholder="password" value="" required="required"><br><br>
            <input type="submit" name="submit" value="Log In"><br>
       </form>
       <?php
        if (isset($_SESSION['message'])) {
            echo '<p id="msg" style="text-align:center"> ' . $_SESSION['message'] . ' </p>';
        }
        unset($_SESSION['message']); 
        ?>
       <div id="two">
       <a href="/reset">FORGOT PASSWORD?</a><br>
      </div>
      </div>
      <br>
    <div id="three">
        DON'T HAVE AN ACCOUNT? <a href="/signup">SIGN UP</a><br>
    </div>
        </div>
    </body>
    </html>