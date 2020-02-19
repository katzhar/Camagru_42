let imgpost;
let unlike = 'https://sun9-29.userapi.com/c204628/v204628996/68538/_YhiX3RefCg.jpg';
let value;
let input;

function getLike(post) {
    let namepost = 'img_'+ post;
    imgpost = document.getElementById(namepost);
    console.log(imgpost.src);
    if(imgpost.src === unlike){
        imgpost.src ='https://sun9-43.userapi.com/c204628/v204628996/6853f/eltI7W9Ft7M.jpg';
        like(post);
    }
    else {
        imgpost.src = 'https://sun9-29.userapi.com/c204628/v204628996/68538/_YhiX3RefCg.jpg';
        dislike(post);
    }
}
async function like(post) {
    let like = 'p_' + post;
    let value = document.getElementById(like).innerHTML;

    value++;
    document.getElementById(like).innerHTML = ' ' + value;
    value = post + '_' + 'like';
    document.getElementById('formlike_' + post).setAttribute('action', '/main/likes/' + value);
    // document.getElementById('formlike_'+ post).submit();
    let response = await fetch('/main/likes/'+ value);


}
async function  dislike(post) {

    let like = 'p_'+ post;
    value = document.getElementById(like).innerHTML;
    value--;
    document.getElementById(like).innerHTML = ' ' + value;
    value = post + '_' + 'dislike';
    document.getElementById('formlike_' + post).setAttribute('action', '/main/likes/' + value);
    // document.getElementById('formlike_'+ post).submit();
    let response = await fetch('/main/likes/'+ value);
}
async function deletePost(post_id) {
    let result = confirm('Are you sure you want to delete the post?');
    if(result === true)
    {
        document.getElementById('post_' + post_id).remove();
       let response = await fetch('/main/delete/'+ post_id);
    }
}

window.onload = function () {
    let commentForm = document.querySelectorAll('.com_form .submitForm');
    if (commentForm !== null) {
        commentForm.forEach(function (el) {
            let post_id = el.previousElementSibling;
            let comTest = el.nextElementSibling;
            el.onclick = async function (event){

                event.preventDefault();
                let data = {
                    "post_id": post_id.value,
                    "comment": comTest.value
                };
                let comm = await fetch('/main/comments/', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data),
                });
                let commentData = await comm.json();
                if (commentData) {
                    let commentBlock = document.querySelector(".item__detail_"+ post_id.value );
                    let commentRow = document.createElement("div");
                    let tmp = 'detail__row' + commentData['comm_id'];
                    commentRow.id = 'comm_' + commentData['comm_id'];
                    commentRow.classList.add(tmp);
                    let commentLogin = document.createElement('a');
                    commentLogin.setAttribute("onclick", 'DelCom(' + commentData['comm_id'] + ')');
                    commentLogin.classList.add("item__user-name");
                    commentLogin.innerHTML = commentData['login'] + ' ';
                    let commentDescription = document.createElement('span');
                    commentDescription.classList.add('item__user-description');
                    commentDescription.innerText = data['comment'];
                    commentRow.appendChild(commentLogin);
                    commentRow.appendChild(commentDescription);
                    commentBlock.appendChild(commentRow);
                    comTest.value = '';
                    let br = document.createElement("br");
                    commentBlock.appendChild(br);

                }
            }
        })
    }
};

async function DelCom(idcom) {
    let result = confirm('Are you sure you want to delete the comment?');
    if (result === true) {
        document.getElementById('comm_' + idcom).remove();
   let response = await fetch('/main/delete/'+ idcom + '_comm');
}
}
function pagination(id) {
    let form_page = document.getElementById("form_page");
    let value_page = document.getElementById("value_page");
    value_page.setAttribute('value', id);
    document.forms['form_page'].submit();
}
