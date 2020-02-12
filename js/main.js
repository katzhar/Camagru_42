let unlike = 'http://localhost:8080/images/unlike.png';
let value;
let input;
let comment;
let imgpost;

function getLike(post) {
    let namepost = 'img_'+ post;
    imgpost = document.getElementById(namepost);
    console.log(imgpost.src);
    if(imgpost.src === unlike) {
    imgpost.src ='images/like.png';
    like(post);
    }
    else {
        imgpost.src = 'images/unlike.png';
        dislike(post);
    }
}

async function like(post) {
    let like = 'p_' + post;
    let value = document.getElementById(like).innerHTML;

    value++;
    document.getElementById(like).innerHTML = value;
    value = post + '_' + 'like';
    document.getElementById('formlike_' + post).setAttribute('action', '/main/likes/' + value);
    let response = await fetch('/main/likes/'+ value);
}

async function  dislike(post) {
    let like = 'p_'+ post;
    value = document.getElementById(like).innerHTML;
    value--;
    document.getElementById(like).innerHTML = value;
    value = post + '_' + 'dislike';
    document.getElementById('formlike_' + post).setAttribute('action', '/main/likes/' + value);
    let response = await fetch('/main/likes/'+ value);
}

async function getComment(post) {
    comment =  document.getElementById('comments_' + post).value;
    let login = document.getElementById('user_id').value;
    let sp1 = document.createElement("div");
    var sp2 = document.getElementById("childElement");
    //Получаем ссылку на родителя sp2
    var parentDiv = sp2.parentNode;
    sp1.innerHTML = comment;
    // Вставляем sp1 перед sp2
    parentDiv.insertBefore(sp1, sp2);
    let p_login = document.createElement("bold");
        // Получаем ссылку на элемент, перед которым мы хотим вставить sp1
    //Получаем ссылку на родителя sp2
    var parentDiv = sp2.parentNode;
    p_login.innerHTML = login;
    // Вставляем sp1 перед sp2
    parentDiv.insertBefore( p_login, sp2);
        //Получаем ссылку на родителя sp2
    var parentDiv = sp2.parentNode;
    sp1.innerHTML = comment;
    // Вставляем sp1 перед sp2
    parentDiv.insertBefore(sp1, sp2);
    document.getElementById('comments_' + post).value = '';
    value = post + '_' + comment;
    let response = await fetch('/main/comments/'+ value);
}
