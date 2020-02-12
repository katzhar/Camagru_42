<head>
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
<?php
if (!isset($_SESSION['login']) and !isset($_SESSION['password']))
        header ('Location: ../main');
?>
<div id="container_1">
  <div id="container_2">
    <div id="left">
    <p style="font-weight: bold"><a href="../settings">Settings</a><p><br>
    <h5><a href="../settings">Change username</a></h5>
    <h5><a href="../settings/changeemail">Change e-mail</a></h5>
    <h4><a href="../settings/changepassword">Change password</a></h4>
    </div>
        <div id="right">
        <form method="post" action="/settings/confirmpassword">
               old password <input type="password" name="password_old" value="" required="required"><br><br>
               new password <input type="password" name="password_new" value="" required="required"><br><br>
               confirm password <input type="password" name="password_confirm"  value="" required="required"><br><br>
                <input type="submit" name="submit" value="change password"><br><br>
                <a id="a" href="../reset">forgot password?</a><br><br>
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