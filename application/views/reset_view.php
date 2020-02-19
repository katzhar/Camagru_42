<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
    <link href="../css/style.css" rel="stylesheet">
    <style>
        div {
            border-radius: 3px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
        a {
            text-decoration: none;
            color: rgb(82, 82, 82);
        }
        a:hover {
            font-weight: bold; 
        }
    </style>
    	<title>Camagru | Reset password</title>
    <body id="body_reset">
      <div id="container_reset">
        <div id="one"><a href="/main">CAMAGRU</a><br><br>
            <form id="form_reset" method="post" action="/reset/update">
                <input class = 'reset_inp' type="text" name="email" placeholder="e-mail" value="" required="required"><br><br>
                <input class = 'reset_sub' type="submit" name="submit" value="Reset password"><br>
       </form>
       <?php
            if (isset($_SESSION['message'])) {
                echo '<p id="msg" style="text-align:center"> ' . $_SESSION['message'] . ' </p>';
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