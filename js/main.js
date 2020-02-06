let imgpost;
let unlike = 'http://localhost:8080/images/unlike.png';
function getLike(post) {
    let namepost = 'img_'+ post;
imgpost = document.getElementById(namepost);
    console.log(imgpost.src);
 if(imgpost.src === unlike){
    imgpost.src ='images/like.png';
}
else
 imgpost.src ='images/unlike.png';

}

// let galleryList = document.querySelector('.main__area');
// galleryList.onclick = async function (event) {
//     let target = event.target; // Где был клик?
//     let likedPostId = target.closest('.main__item').getAttribute("id");
//     if (target.parentElement.classList.contains('main__item_like') && !(target.parentElement.classList.contains('active'))) {
//         toggleClass(target.parentElement);
//         let likeElement = target.parentElement.parentElement.children[1];
//         likeElement.innerHTML = Number(likeElement.innerHTML) + 1;
//         let response = await fetch('/news/like/add/' + likedPostId);
//     } else if (target.parentElement.classList.contains('main__item_like') && target.parentElement.classList.contains('active')) {
//         toggleClass(target.parentElement);
//         let likeElement = target.parentElement.parentElement.children[1];
//         likeElement.innerHTML = Number(likeElement.innerHTML) - 1;
//         let response = await fetch('/news/like/remove/' + likedPostId);
//     }
// };
