let lateralBar = document.querySelector('.lateralBar');
let lateralBarInvisible = document.querySelector('.lateralBarInvisible');
lateralBar.classList.add('lateralBarOpen'); 
let mainGestao = document.getElementById("main-gestao");
function barraLateral() {
    let spans = document.querySelectorAll('.lateralBar span');
    if (lateralBar.classList.contains('lateralBarOpen')) {
        lateralBar.classList.remove('lateralBarOpen');
        lateralBar.style.width = '0%';
        lateralBarInvisible.style.width = '0%';
        mainGestao.style.width = "100%";
        spans.forEach(span => {
            span.style.opacity = '0';
        });
        setTimeout(() => {
            lateralBar.style.display = 'none'; 
            lateralBarInvisible.style.display = 'none'; 
        }, 500); 
    } else {
        lateralBar.style.display = 'block'; 
        lateralBarInvisible.style.display = 'block';
        setTimeout(() => {
            lateralBar.style.width = '15%';
            lateralBarInvisible.style.width = '15%';
            mainGestao.style.width = "85%"; 
        }, 10); 
        setTimeout(() => {
            spans.forEach(span => {
                span.style.opacity = '1'; 
            });
        }, 450);
        lateralBar.classList.add('lateralBarOpen'); 
    }
}

let menuUser = document.querySelector('.menu-user');
menuUser.classList.add('menuUserOpen');

function openMenuUser(){
    if(menuUser.classList.contains('menuUserOpen')){
        menuUser.style.opacity = "1";
        menuUser.style.display = "flex";
        menuUser.classList.remove('menuUserOpen');
    }else{
        menuUser.style.opacity = "0";
        menuUser.style.display = "none";
        menuUser.classList.add("menuUserOpen");
    }
}

let menuNotification = document.querySelector('.menu-notification');
menuNotification.classList.add('menuNotificationOpen');

function openMenuNotification(){
    if(menuNotification.classList.contains('menuNotificationOpen')){
        menuNotification.style.opacity = "1";
        menuNotification.style.display = "flex";
        menuNotification.classList.remove('menuNotificationOpen');
    }else{
        menuNotification.style.opacity = "0";
        menuNotification.style.display = "none";
        menuNotification.classList.add("menuNotificationOpen");
    }
}
 