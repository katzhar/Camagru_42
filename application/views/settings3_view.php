<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camagru | Settings</title>
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<?php
if (!isset($_SESSION['login']) and !isset($_SESSION['password']))
        header ('Location: ../main');
?>
<div id="container_1">
  <div id="container_2">
    <div id="left_column">
    <p style="font-weight: bold"><a href="../settings">Settings</a><p><br>
    <h5><a href="../settings">Change username</a></h5>
    <h5><a href="../settings/changeemail">Change e-mail</a></h5>
    <h4><a href="../settings/changepassword">Change password</a></h4>
    </div>
        <div id="right_column">
        <form method="post" action="/settings/confirmpassword">
               old password <input type="password" name="password_old" value="" required="required"><br><br>
               new password <input type="password" name="password_new" value="" required="required"><br><br>
               confirm password <input type="password" name="password_confirm"  value="" required="required"><br><br>
                <input type="submit" name="submit" value="change password"><br><br>
                <a id="a" href="../reset">forgot password?</a><br><br>
        </form>
        <?php
            if (isset($_SESSION['message'])) {
                echo '<p id="msg" style="text-align:left"> ' . $_SESSION['message'] . ' </p>';
            }
            unset($_SESSION['message']); 
        ?>
        </div>
    <div class="clear"></div>
  </div>
</div>
</body>
</html>