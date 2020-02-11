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

$postlike = false;
    if (isset($data['like_post']) && $data['like_post'] != NULL) {
        $like = $data['like_post'];
        unset($data['like_post']);
    } else {
        unset($data['like_post']);
        $like = NULL;
    }
    if (isset ($data['like_post']) && $data['comments'] != NULL) {
        $comment = $data['comments'];
        unset($data['comments']);
    } else {
        $comment = NULL;
        unset($data['comments']);
    }
    foreach ($data as $value) {
        echo <<<POST
<div class="post">
<img class = 'post_img' src=images/user_image/{$value['Image']}></a><br><br>
<p>{$value['Creation_Date']}</p><p>{$value['Message']}</p>
POST;
        if(isset($like))
        foreach ($like as $id) {
            if (isset($_SESSION['login']) && ($value['Post_ID'] === $id['Post_ID'])) {
                echo <<< LIKES
 <form id = "formlike_{$value['Post_ID']}" action="/main/likes" method=POST>
 <p id = 'p_{$value['Post_ID']}'>{$value['Likes']}</p><img  id = 'img_{$value['Post_ID']}' src = 'images/like.png' onclick="getLike({$value['Post_ID']})" width="35px" height="30px">
                </form>
LIKES;
                $postlike = true;
            }
        }
        else if (!isset($_SESSION['login']))
        {
            echo <<< UNLIKES
 <form id = "formlike_{$value['Post_ID']}" action="/main/likes" method=POST>
 <p id = 'p_{$value['Post_ID']}'>{$value['Likes']}</p><img  id = 'img_{$value['Post_ID']}' src = 'images/unlike.png'  width="35px" height="30px">
                </form>
UNLIKES;
        }
        if (isset($_SESSION['login']) && $postlike === false) {
            echo <<< UNLIKES
 <form id = "formlike_{$value['Post_ID']}" action="/main/likes" method=POST>
 <p id = 'p_{$value['Post_ID']}'>{$value['Likes']}</p><img  id = 'img_{$value['Post_ID']}' src = 'images/unlike.png' onclick="getLike({$value['Post_ID']})" width="35px" height="30px">
                </form>
UNLIKES;
        }
        if(isset($_SESSION['login']))
            $id = $_SESSION['login'];
        else
            $id = 0;
        $postlike = false;
        echo <<<COMMENT
<div id="parentElement">
  <span id="childElement">Comments</span>
  <input id = 'user_id' value = '{$id}'style="display: none">
</div>

<div class="comments_{$value['Post_ID']}"
<form method='post' value='' action="/main/comments/" name="formname" target="_parent">
<textarea id="comments_{$value['Post_ID']}" value = '' class = 'comments' name="message">Add a comment...</textarea>
<input  class = 'comments' onclick="getComment({$value['Post_ID']})" name="submit" type="submit" value="Post">
</form></div>
</div>
<br>
COMMENT;
}
?>
</body>
</html>