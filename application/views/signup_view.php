<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="../css/style.css" rel="stylesheet">
<title>Camagru | Sign Up</title>
</head>
    <style>
        div {
            border-radius: 3px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            text-decoration: none;
        }
        a {
            text-decoration: none;
            color: rgb(82, 82, 82);
        }
    </style>
<body id="body_signup">
      <div id="container_signup">
        <div id="one"><a href="/main">CAMAGRU</a><br><br>
            <form id="form_signup" method="post" action="/signup/create">
                <input type="text" name="email" placeholder="email" value="" required="required"><br><br>
                <input type="text" name="login" placeholder="login" value="" required="required"><br><br>
                <input type="password" name="password" placeholder="password" value="" required="required"><br><br>
                <input type="password" name="password_confirm" placeholder="repeat your password" value="" required="required"><br><br>
                <input type="submit" name="submit" value="Sign Up"><br>
       </form>
            <?php
            if (isset($_SESSION['message'])) {
                echo '<p id="msg"> ' . $_SESSION['message'] . ' </p>';
            }
            unset($_SESSION['message']);
            ?>
    </div>
    <br>
        <div id="three">
            ALREADY HAVE AN ACCOUNT? 
            <a href="/auth">LOG IN</a><br>
        </div>
    </div>
    </body>
    </html>