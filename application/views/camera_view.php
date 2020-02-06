<script src="/js/camera.js"></script>
<form id="upload_form" enctype="multipart/form-data" action="/camera/upload/" method="post">
    <input id=" before" name="picture" type="file" />
    <input type="submit" value="Загрузить" />
    </form>
<!--<form id="upload_camera" enctype="multipart/form-data"  method="post">-->
<video id="video" width="640" height="480" autoplay></video>
    <button id="snap" type="submit" >Snap Photo</button>
<div id="stickers">
    <label><input type="radio" onclick="checkClick('_1')" name="k"><img id = "_1" width="180px" height="180px" src="/images/1.png"></label>
    <label><input type="radio" onclick="checkClick('_2')"  name="k"><img id = "_2" width="180px" height="180px" src="/images/2.png"></label>
    <label><input type="radio" onclick="checkClick('_3')"  name="k"><img id = "_3" width="180px" height="180px" src="/images/3.png"></label>
    <label><input type="radio" onclick="checkClick('_4')"  name="k"><img id = "_4" width="180px" height="180px" src="/images/4.png"></label>
    <label><input type="radio" onclick="checkClick('_5')"  name="k"><img id = "_5" width="180px" height="180px" src="/images/5.png"></label>
    <hr>
</div>
<canvas id="canvas" width="640" height="480"></canvas>
<div id="side_menu">
    <div id="description" style="text-align: center">Description<br><input type="text" form="upload_form" maxlength="250" name="description"></div>
    <input style="display: none" id="submit" type="submit" form="upload_form">
    <button id="bsubmit" style="display: none" onclick="submit();" id="buba">SEND IMAGE</button>
</div>
</div>
<canvas id="hide_canv" style="display: none" width="640" height="480"></canvas>

