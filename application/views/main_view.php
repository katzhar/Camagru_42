<!DOCTYPE html>
<head>
    <title>Camagru</title>
    <style>
    .likes {
        color: black;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }
    .post {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        font-size: 15px;
    }
    .input_form {
        padding: 5px;
        margin: 5px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
    .img_post {
        width: 680;
        height: 480;
        border-radius: 7px;
        border: outset;
    }
    #creation_date {
        font-size: 10px;
        color: gray;
    }
    #submit_button {
        background-color: #f1f1f1;
        color: black;
        padding: 5px;
        margin: 8px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
        cursor: pointer;
}
    </style>
</head>
<body>
<script src='/js/main.js'></script>
<?php
$postlike = false;


if (isset ($data['comments']) && $data['comments'] != NULL) {
    $comment = $data['comments'];
    unset($data['comments']);
} else {
    $comment = NULL;
    unset($data['comments']);
}

    if (isset($data['like_post']) && $data['like_post'] != NULL) {
        $like = $data['like_post'];
        unset($data['like_post']);
    } else {
        unset($data['like_post']);
        $like = NULL;
    }
    foreach ($data as $value) {
        if(isset($_SESSION['id']) && $_SESSION['id'] == $value['User_ID']) {
            echo <<<POST
<div id="post_{$value['Post_ID']}" style="display:block">
<img class = 'delete'   onclick="deletePost({$value['Post_ID']})" src = '/images/delete.png' width="50" height="50">
<p>{$value['login']}</p>
<img class = 'post_img' src=images/user_image/{$value['Image']}></a><br><br>
<p>{$value['Creation_Date']}</p><p>{$value['Message']}</p>
POST;
        }
        else
            echo <<<POST
<div class="post">
<p>{$value['login']}</p>
<img class = 'post_img' src=images/user_image/{$value['Image']}></a><br><br>
<p>{$value['Creation_Date']}</p><p>{$value['Message']}</p>
POST;

        if(isset($like))
        foreach ($like as $id) {
            if (isset($_SESSION['login']) && ($value['Post_ID'] === $id['Post_ID'])) {
                echo <<< LIKES
 <form class="likes" id="formlike_{$value['Post_ID']}" action="/main/likes" method=POST>
 <img id='img_{$value['Post_ID']}' src='images/like.png' onclick="getLike({$value['Post_ID']})" width="20px" height="15px"><a id = 'p_{$value['Post_ID']}'>  {$value['Likes']}</a>
    </form>
LIKES;
                $postlike = true;
            }
        }
        else if (!isset($_SESSION['login'])) {
            echo <<< UNLIKES
<div class="like">
            <form id = "formlike_{$value['Post_ID']}" action="/main/likes" method=POST>
            <p id = 'p_{$value['Post_ID']}'>{$value['Likes']}</p><img  id = 'img_{$value['Post_ID']}' src = 'https://sun9-29.userapi.com/c204628/v204628996/68538/_YhiX3RefCg.jpg' style="display: block" width="35px" height="30px">
            </form></div>
UNLIKES;
        }
        if (isset($_SESSION['login']) && $postlike === false) {
            echo <<< UNLIKES
        <form id = "formlike_{$value['Post_ID']}" action="/main/likes" method=POST>
            <p id = 'p_{$value['Post_ID']}'>{$value['Likes']}</p><img  id = 'img_{$value['Post_ID']}' src = 'https://sun9-29.userapi.com/c204628/v204628996/68538/_YhiX3RefCg.jpg' onclick="getLike({$value['Post_ID']})" width="35px" height="30px">
        </form>
UNLIKES;
        }
        if (isset($_SESSION['login']))
            $idd = $_SESSION['login'];
        else
            $idd = 0;
        $postlike = false;
if(isset($comment))
    foreach ($comment as $id) {
        if($id['Post_ID'] === $value['Post_ID']){
            if( isset($_SESSION['login']) && ($_SESSION['login'] === $id['Login']))
            echo <<< COMM
<div id = "comm_{$id['id']}" style="display: block">
<a onclick="DelCom({$id['id']})">{$id['Login']}  </a><span>{$id['Comment']}</span>
</div><br>
COMM;
            else
                echo <<< COMM
<div id = "{$id['id']}"><br>
<a>{$id['Login']}  </a><span>{$id['Comment']}</span>
</div><br>
COMM;

        }
    }
        if (isset($_SESSION['login'])) {
            echo <<<COMMENT
<div class = 'item__detail_{$value['Post_ID']}'>
<div id="parentElement">
  <span id="childElement"></span>
 <input id='user_id' value = '{$idd}'style="display:none"> 
</div>
 </div>
 <br>
  <form class="com_form" action="/main/comments" >
   <input type="text" value = '{$value['Post_ID']}' class="idContainer" style="display: none">
   <input type="submit" class="submitForm" value="comment">
   <input type="text"  class="new_com" required>
 </form>
</div>
</div>
<hr>
COMMENT;
        }
    }
?>
</body>
<div class="footer"><a href="/camera"><img id="logo_temp" src="https://i.pinimg.com/originals/2a/f7/0b/2af70b7eb1194dfea457cdc3b386691b.png"></a></div>
 </body>
</html>














