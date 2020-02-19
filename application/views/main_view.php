<script src='/js/main.js'></script>
<div class = 'layout'>
    <div class="inner">
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
<img class = 'delete' onclick="deletePost({$value['Post_ID']})" src = '/images/delete.png' width="20" height="20">
<p id="login_post">{$value['login']}</p>
<img class = 'post_img' src=images/user_image/{$value['Image']}></a><br>
<p id="creation_date_post">{$value['Creation_Date']}</p><p>{$value['Message']}</p>
POST;
            }
            else
                echo <<<POST
<div class="post">
<p id="login_post">{$value['login']}</p>
<img class = 'post_img' src=images/user_image/{$value['Image']}></a><br>
<p id="creation_date_post">{$value['Creation_Date']}</p><p>{$value['Message']}</p>
POST;

            if(isset($like))
                foreach ($like as $id) {
                    if (isset($_SESSION['login']) && ($value['Post_ID'] === $id['Post_ID'])) {
                        echo <<< LIKES
<div class="like">
 <form class="likes" id="formlike_{$value['Post_ID']}" action="/main/likes" method=POST>
 <img id='img_{$value['Post_ID']}' src='https://sun9-43.userapi.com/c204628/v204628996/6853f/eltI7W9Ft7M.jpg' onclick="getLike({$value['Post_ID']})" width="20px" height="15px"><a id = 'p_{$value['Post_ID']}'>  {$value['Likes']}</a>
    </form></div>
LIKES;
                        $postlike = true;
                    }
                }
            else if (!isset($_SESSION['login'])) {
                echo <<< UNLIKES
<div class="like">
            <form id = "formlike_{$value['Post_ID']}" action="/main/likes" method=POST>
            <img  id = 'img_{$value['Post_ID']}' src='https://sun9-29.userapi.com/c204628/v204628996/68538/_YhiX3RefCg.jpg' style="display: block" width="20px" height="15px"><a id = 'p_{$value['Post_ID']}'>  {$value['Likes']}</a>
            </form></div>
UNLIKES;
            }
            if (isset($_SESSION['login']) && $postlike === false) {
                echo <<< UNLIKES
<div class="like">
        <form id = "formlike_{$value['Post_ID']}" action="/main/likes" method=POST>
            <img  id = 'img_{$value['Post_ID']}' src='https://sun9-29.userapi.com/c204628/v204628996/68538/_YhiX3RefCg.jpg' onclick="getLike({$value['Post_ID']})" width="20px" height="15px"><a id = 'p_{$value['Post_ID']}'>  {$value['Likes']}</a>
        </form></div>
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
<div class = 'comments'>
<div id = "comm_{$id['id']}" style="display: block">
<a onclick="DelCom({$id['id']})">{$id['Login']}  </a><span>{$id['Comment']}</span><br>
</div></div>
COMM;
                        else
                            echo <<< COMM
<div class = 'comments'>
<div id = "{$id['id']}">
<a>{$id['Login']}  </a><span>{$id['Comment']}</span>
</div></div>
COMM;
                    }
                }
            if (isset($_SESSION['login'])) {
                echo <<<COMMENT
<div class = 'comments'>
<div class = 'item__detail_{$value['Post_ID']}'>
<div id="parentElement">
  <span id="childElement"></span>
 <input id='user_id' value = '{$idd}'style="display:none"> 
</div>
 </div>
  <form class="com_form" action="/main/comments" >
   <input type="text" value = '{$value['Post_ID']}' class="idContainer" style="display: none">
   <input type="submit" class="submitForm" value="POST">
   <input type="text"  class="new_com" required placeholder=" add a comment ...">
 </form>
</div>
</div>

COMMENT;
            }
        }
        ?>
        <div id = 'page'>
            <?php
            $pages = ceil($_SESSION['count_post']/5);
            for($i = 1; $i <= $pages;$i++)
                echo <<< A
<a id = 'page_{$i}' onclick="pagination({$i})">{$i} </a>
A;
            ?>
        </div>
    </div>
</div>
<div class="footer" id = "footer">
    <div id = 'camera'>
        <a href="/camera"><img id="logo_temp" src="https://i.pinimg.com/originals/2a/f7/0b/2af70b7eb1194dfea457cdc3b386691b.png"></a>
    </div>
    <div style="display: none">
        <form method = 'POST' id = 'form_page' action="/">
            <input id = 'value_page' type = 'text' name="number_page">
            <input type ='submit'>
        </form>
    </div>
</div>
<?php
if (isset($_SESSION['login']))
{
    echo <<< CAMERA
CAMERA;

}
?>














