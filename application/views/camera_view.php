<script src="/js/camera.js"></script>
<style>
    #test{
        display: flex;
        flex-direction: row;
    }
    #prew_img  {
        display: flex;
        flex-direction: row;
    }
    #prew_img  img{
        width: 180px;
        height: 135px;
    }
    #preview{
        display: inline-block;
        width: 640px;
        height: 50px;
    }
    #logo_temp {
        width: 30px; 
        height: 25px;
        align-items: center;
    }
    .header { 
        background: #d0d0e1; 
        position: fixed;
        height: 40px;
        width: 99%;
        color: black;
        padding: 5px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        top: 0;
    }
    .logo {
        float: left;
        padding: 12px;
    }
    nav {
        float: right;
        padding: 5px;
    }
    nav ul {
        margin: 0;
        padding: 0;
    }
    nav li {
        display: inline-block;
        padding: 5px;
    }
    #upload_form {
        padding-top: 50px;
    } 
    #description {
        padding: 5px;
        margin: 5px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
    .upload_button {
        background-color: #f1f1f1;
        color: black;
        padding: 5px;
        margin: 8px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
        cursor: pointer;
    }
    #before {
        background-color: #f1f1f1;
        color: black;
        padding: 3px;
        margin: 8px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
        cursor: pointer;
    }
        a {
        text-decoration: none;
        color: black;
    }
    a:hover {
        text-decoration: none;
        font-weight: bold;
    }
</style>
 <div class="header" style="text-decoration:none; color:black">
 <div class="logo"><a style="text-decoration:none; color:black" href="/main">CAMAGRU</a></div>
 <nav>
 <ul>
	<?php
        if (!isset($_SESSION['login']) and !isset($_SESSION['password'])) {
                echo "<li><a style='text-decoration:none; color:black'; href='/auth'>Sign In</a></li>";
                echo "<li><a style='text-decoration:none; color:black'; href='/signup'>Sign Up</a>";
        }
        else {
            echo "<li><a style='text-decoration:none; color:black'; href='/main'>{$_SESSION['login']}</a></li>";
            echo "<li><a style='text-decoration:none; color:black'; href='/settings'>Settings</a></li>";
            echo "<li><a style='text-decoration:none; color:black'; href='/auth/signout'>Sign Out</a></li>";
        }
  ?>  
      </ul>
    </nav>
 </div>
<?php
if (isset($_SESSION['message'])) {
    echo '<p id="msg"> ' . $_SESSION['message'] . ' </p>';
}
unset($_SESSION['message']);
?>

<form id="upload_form" enctype="multipart/form-data" action="/camera/upload/" method="post">
    <input id=" before" name="picture" type="file" />
    <input type="submit" value="Загрузить" />
</form>
<div id = "test">
<video id="video" width="640" height="480" autoplay></video>
    <div id="stickers">
        <label><input type="radio" onclick="checkClick('_1')" name="k"><img id = "_1" width="180px" height="180px" src="/images/1.png"></label>
        <label><input type="radio" onclick="checkClick('_2')"  name="k"><img id = "_2" width="180px" height="180px" src="/images/2.png"></label>
        <label><input type="radio" onclick="checkClick('_3')"  name="k"><img id = "_3" width="180px" height="180px" src="/images/3.png"></label>
        <label><input type="radio" onclick="checkClick('_4')"  name="k"><img id = "_4" width="180px" height="180px" src="/images/4.png"></label>
        <label><input type="radio" onclick="checkClick('_5')"  name="k"><img id = "_5" width="180px" height="180px" src="/images/5.png"></label>
    </div>
</div>
<button id="preview" type="submit"  style = 'display: none'>Snap Photo</button>
<p>Preview</p>
 <div id = "prew_img">
     <?php
     foreach ($data as $value){
         echo <<< IMGTMP
<img id = "{$value['id']}" onclick="getPostImg({$value['id']})" src="/images/user_image/{$value['Image']} ">
IMGTMP;
     }
     ?>
</div>
<hr>
<div id="side_menu">
    <?php
    if(!isset($_SESSION['user_file']) ||$_SESSION['user_file'] === '' )
    {
    echo <<<IMG
        <img id = 'image_done' width="640" height="480" src = '' style="display: none">
        <p>Description</p><br>
        <textarea  type="text" id="description" form="upload_form" maxlength="250" name="description"></textarea></div>
        <button id="snap" style="display: none"  type="submit" >SEND IMAGE</button>
        </div>
        <input style="display: none" id="submit" type="submit" form="upload_form">
        <canvas id="hide_canv" style="display: none" width="640" height="480"></canvas>
IMG;
    }
    else {
        echo <<<IMG
        <img id = 'image_done' width="640" height="480" src = '{$_SESSION['user_file']}'>
        <p>Description</p><br>
        <textarea  type="text"  pattern="/(^[a-z0-9._?!\ \)\(']{0,256}$)/i" id="description" form="upload_form" maxlength="250" name="description"></textarea></div>
<button id="snap" type="submit" onclick = 'get_post({$_SESSION['id_user_file']})' >SEND IMAGE</button>
</div>
<input style="display: none" id="submit" type="submit" form="upload_form">
<canvas id="hide_canv" style="display: none" width="640" height="480"></canvas>

IMG;
        $_SESSION['user_file'] = '';
        $_SESSION['id_user_file'] = '';
    }
?>

