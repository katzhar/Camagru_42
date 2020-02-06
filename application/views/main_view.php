<!DOCTYPE html>
<html lang="en">
<head>
    <title>Camagru</title>
    <style>
    </style>
</head>
<body>
<p align="center">WELCOME TO CAMAGRU, DARLING</p>
<script src = '/js/main.js'></script>

<?php
foreach ($data as $value)
{
    echo <<<POST
<div class="post">
<img class = 'post_img' src=images/user_image/{$value['Image']}></a><br><br>
<p>{$value['Creation_Date']}</p><p>{$value['Message']}</p>
POST;
    echo <<< LIKES
 <form action=/main/like/{$value['Post_ID']} method=POST>
    <img  id = 'img_{$value['Post_ID']}' src = 'images/unlike.png' onclick="getLike({$value['Post_ID']})" width="35px" height="30px">
                </form>
LIKES;
    echo <<<COMMENT
<div class="comments_{$value['Post_ID']}"
<form  method='post' action="" name="formname" target="_parent"><textarea class = 'comments' name="message">Add a comment...</textarea><input  class = 'comments' name="submit" type="submit" value="Post">
</form></div>
</div>
<br>
COMMENT;
}
?>
</body>
</html>