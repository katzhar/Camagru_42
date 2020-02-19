
let isVideo = false;
let elem;
let t = false;
let imgs;
let sentSt;
let sent;
window.onload = function() {
    video = document.getElementById('video');
    start_camera();
    document.getElementById('preview').addEventListener('click', get_foto);
};

function get_foto() {
    if (!isVideo) alert('Нажмите "разрешить" в верху окна');
    document.getElementById('upload_form').setAttribute('action', '/camera/canvas/');
    let base = video_to_base64();
    let binput = document.createElement('input');
    document.body.insertBefore(binput,document.getElementById('before'));
    binput.setAttribute('type', 'text');
    binput.setAttribute('form', 'upload_form');
    binput.setAttribute('name', 'base_img');
    binput.style.display = 'none';
    binput.setAttribute('value', base);
    let input = document.createElement('input');
    document.body.insertBefore(input,document.getElementById('before'));
    input.setAttribute('type', 'text');
    input.setAttribute('form', 'upload_form');
    input.setAttribute('name', 'sent_sticker');
    input.style.display = 'none';
    sentSt= imgs.id + '_' + elem.style.left + '_' + elem.style.top;
    input.setAttribute('value', sentSt);
    document.getElementById('submit').click();
}

function video_to_base64() {
    let hcanvas = document.getElementById('hide_canv');
    hcanvas.getContext('2d').drawImage(video, 0, 0, 640, 480);
    let base = hcanvas.toDataURL();
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

function delElement(tmp) {
    document.getElementById(tmp.id).remove();
    document.getElementById('preview').style.display = 'none';
}

function checkClick(id) {
    t = false;
    if ( document.getElementById("selectSt" + id) !== null) {
        t = true;
        delElement(document.getElementById("selectSt" + id));
    }
    for (let i = 1; i < 6; i++) {
        if (document.getElementById("selectSt" + '_' + i) !== null)
            delElement(document.getElementById("selectSt" + '_' + i));
     }
if (t == false) {
    imgs = new Image(180, 180);
    imgs.id = "selectSt" + id;
    imgs.src = document.getElementById(id).currentSrc;
    dragElement(imgs);
    document.getElementById('preview').style.display = '';
}
}

function dragElement(imgs) {
    document.body.appendChild(imgs);
    elem = document.getElementById(imgs.id);
    document.body.appendChild(elem);
    // 2. разместить на том же месте, но в абсолютных координатах
    elem.style.position = 'absolute';
    elem.style.left = '264px';
    elem.style.top = '269px';
    // переместим в body, чтобы стикер был точно не внутри position:relative
    elem.style.zIndex = 1000; // показывать стикер над другими элементами
    elem.onmousedown = function (e) { // 1. отследить нажатие (https://learn.javascript.ru/drag-and-drop)
        moveAt(e);
        // передвинуть стикер под координаты курсора
        // и сдвинуть на половину ширины/высоты для центрирования
        function moveAt(e) {
            let eWidth = e.pageX - elem.offsetWidth / 2;
            let eHeight  = e.pageY - elem.offsetHeight / 2;
            console.log(eWidth);
            console.log(eHeight);
            if (eWidth > 487)
                eWidth = 487;
            if (eWidth < 30)
                eWidth = 30;
            if (eHeight > 428)
                eHeight = 428;
            if (eHeight < 128)
                eHeight = 128;
            elem.style.left = eWidth + 'px';
            elem.style.top = eHeight + 'px';

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

function getPostImg (id_img){
    let imgdone =document.getElementById('image_done');
    imgdone.src = document.getElementById(id_img).src;
    imgdone.style.display = '';
    document.getElementById('snap').style.display = '';
    document.getElementById('snap').setAttribute('onclick','get_post(' + id_img + ')');
}

function get_post(id_img) {
    let massage = document.getElementById('description').value;
    if(massage === '')
      alert('Add massage');
    else{
        value = id_img + '_' + massage;
        document.getElementById('upload_form').setAttribute('action', '/camera/get_post/');
        sent = document.createElement('input');
        document.body.insertBefore(sent,document.getElementById('before'));
        sent.setAttribute('type', 'text');
        sent.setAttribute('form', 'upload_form');
        sent.setAttribute('name', 'data');
        sent.style.display = 'none';
        sent.setAttribute('value', value);
        document.getElementById('submit').click();
   }
}