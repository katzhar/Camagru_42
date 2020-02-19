<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/style.css" rel="stylesheet">
    </head>
    <style>
        div {
            border-radius: 3px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
        a {
            text-decoration: none;
            color: rgb(82, 82, 82);
        }
    </style>
    	<title>Camagru | New password</title>
    <body id="body_npass">
      <div id="container_npass">
        <div id="one"><a href="/main">CAMAGRU</a><br><br>
            <form id = "form_npass" method="post" action="/reset/newpassword">
                <input type="password" name="password_new" placeholder="create new password" value="" required="required"><br><br>
                <input type="password" name="password_confirm" placeholder="repeat password" value="" required="required"><br><br>
                <input type="submit" name="submit" value="update"><br>
       </form>
       <?php
            if (isset($_SESSION['message'])) {
                echo '<p id="msg"> ' . $_SESSION['message'] . ' </p>';
            }
            unset($_SESSION['message']); 
        ?>
       <div id="two">
       <a href="/auth">BACK TO LOGIN</a><br>
      </div>
      </div>
      <br>
    <div id="three">
    <a href="/signup">CREATE NEW ACCOUNT</a><br>
    </div>
        </div>
    </body>
    </html>