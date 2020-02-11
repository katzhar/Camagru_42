
let canvas, context;
let isVideo = false;
let elem;
let t = false;
let imgs;
let sentSt;

window.onload = function() {
    canvas = document.getElementById("canvas");
    context = canvas.getContext("2d");
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

}
function checkClick(id) {
   t = false;
     if ( document.getElementById("selectSt" + id) !== null) {
         t = true;
         console.log(t);
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
}
}

function dragElement(imgs) {
    document.body.appendChild(imgs);
    elem = document.getElementById(imgs.id);
    document.body.appendChild(elem);
    // 2. разместить на том же месте, но в абсолютных координатах
    elem.style.position = 'absolute';
    elem.style.left = '232px';
    elem.style.top = '96px';
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
            if (eWidth > 463)
                eWidth = 463;
            if (eWidth < 10)
                eWidth = 10;
            if (eHeight > 339)
                eHeight = 339;
            if (eHeight < 50)
                eHeight = 50;
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