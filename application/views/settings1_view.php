<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Camagru | Settings</title>
<head>
<style>
#container_1 {
        width: 35%;
}
#container_2 {
        margin-left: 100%;
        width: 300%;
}
#left {
        float: left;
        margin-left: -30%;
        margin-right: -100%;
        width: 50%;
}
#right {
        padding-top: 82px;
        font-size: 12px;
}
.clear {
        clear: both;
}
#a {
        color: red;
}
#msg {
            font-weight: bold;
            color: red;
}
</style>
</head>
<body>
<div id="container_1">
  <div id="container_2">
    <div id="left">
    <p style="font-weight: bold"><a href="../settings">Settings</a><p><br>
    <h4><a href="../settings">Edit profile</a></h4>
    <h5><a href="../settings/changepassword">Change password</a></h5>
    </div>
    <div id="right">
    <form method="post" action="/settings/editlogin">
            username <input type="text" name="login_new" placeholder="<?php echo $_SESSION['login'] ?>" value="" ><br><br>
            <input type="submit" name="submit" value="Submit"><br><br>
            </form>
            <form method="post" action="/settings/editemail">
                 e-mail <input type="text" name="email_new" value=""><br><br>
         <input type="submit" name="submit" value="Submit"><br><br>
        </form>
        <?php
            if (isset($_SESSION['message'])) {
                echo '<p id="msg"> ' . $_SESSION['message'] . ' </p>';
            }
            unset($_SESSION['message']); 
        ?>
    </div>
    <div class="clear"></div>
  </div>
</div>
</body>
</html>