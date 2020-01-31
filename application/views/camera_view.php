<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <title>foto</title>
    <link rel="shortcut icon" href="/images/logo.png" type="image/png">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />
    <link href="http://fonts.googleapis.com/css?family=Kreon" rel="stylesheet" type="text/css" />
</head>
<form id="upload_form" enctype="multipart/form-data" action="/camera/upload/" method="post">
    <input id=" before" name="picture" type="file" />
    <input type="submit" value="Загрузить" />
    </form>
<!--<form id="upload_camera" enctype="multipart/form-data"  method="post">-->
<video id="video" width="640" height="480" autoplay></video>
    <button id="snap" type="submit" >Snap Photo</button>
<div id="stickers">
    <img id = "sticker1" width="150px" height="150px" src="/images/1.png">
    <img id = "sticker2" width="150px" height="150px" src="/images/2.png">
    <img id = "sticker3" width="150px" height="150px" src="/images/3.png">
    <img id = "sticker4" width="150px" height="150px" src="/images/4.png">
    <img id = "sticker5" width="150px" height="150px" src="/images/5.png">
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
<script>
    let canvas, context;
    let isDraggable = false;
    let isVideo = false;
    let stickers = [];

    window.onload = function() {
        dragElement(document.getElementById(("sticker1")));
        dragElement(document.getElementById(("sticker2")));
        dragElement(document.getElementById(("sticker3")));
        dragElement(document.getElementById(("sticker4")));
        dragElement(document.getElementById(("sticker5")));
        canvas = document.getElementById("canvas");
        context = canvas.getContext("2d");
        images = document.getElementsByTagName('img');
        video = document.getElementById('video');
        start_camera();
        document.getElementById('snap').addEventListener('click', get_foto);
    };
    function get_foto() {
        if (!isVideo) alert('Нажмите "разрешить" в верху окна');
      //  console.log(canvas.toDataURL()); //вывод
        // Преобразование кадра в изображение dataURL.
        document.getElementById('upload_form').setAttribute('action', '/camera/canvas/');
        let base = video_to_base64();
        let binput = document.createElement('input');
        document.body.insertBefore(binput,document.getElementById('before'));
        binput.setAttribute('type', 'text');
        binput.setAttribute('form', 'upload_form');
        binput.setAttribute('name', 'base_img');
        binput.style.display = 'none';
        binput.setAttribute('value', base);
console.log(binput);
        document.getElementById('submit').click();
    }
    function video_to_base64() {
        hcanvas = document.getElementById('hide_canv');
        hcanvas.getContext('2d').drawImage(video, 0, 0, 640, 480);
        base = hcanvas.toDataURL();
       console.log(base);
        return base;
    }
    function start_camera() {
        if (navigator.mediaDevices.getUserMedia({
            video: true
        }).then(function (stream) {
            video.srcObject = stream;
            video.play();
        })) {
            isVideo = true;
        }
    }

   function dragElement(elem) {

       elem.onmousedown = function (e) { // 1. отследить нажатие (https://learn.javascript.ru/drag-and-drop)

           // подготовить к перемещению
           // 2. разместить на том же месте, но в абсолютных координатах
           elem.style.position = 'absolute';
           moveAt(e);
           // переместим в body, чтобы стикер был точно не внутри position:relative
           document.body.appendChild(elem);

           elem.style.zIndex = 1000; // показывать стикер над другими элементами
           // передвинуть мяч под координаты курсора
           // и сдвинуть на половину ширины/высоты для центрирования
           function moveAt(e) {
               elem.style.left = e.pageX - elem.offsetWidth / 2 + 'px';
               elem.style.top = e.pageY - elem.offsetHeight / 2 + 'px';
           }
// 3, перемещать по экрану
           document.onmousemove = function (e) {
               moveAt(e);
           }
           // 4. отследить окончание переноса
           elem.onmouseup = function () {
               document.onmousemove = null;
               elem.onmouseup = null;
           }
       }
       elem.ondragstart = function() {
           return false;
       }
   }
</script>
</body>
</html>