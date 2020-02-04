<!DOCTYPE html>
<html lang="en">
<head>
    <title>Camagru</title>
    <style>
    </style>
</head>
<body>
<p align="center">WELCOME TO CAMAGRU, DARLING</p>
<?php
foreach ($data as $value)
{
    echo <<<POST
<div class="post_image">
<img  src=images/user_image/{$value['Image']}></a><br />
</div>
<div class="post-message">
<p>{$value['Creation_Date']}</p><p>{$value['Message']}</p>
</div>
<div class="post_comments"
<form method='post' action="" name="formname" target="_parent">
<textarea name="message">Add a comment...</textarea>
<input name="submit" type="submit" value="Post">
</form>
</div>
POST;
}
?>
</body>
</html>