let menu = document.querySelector('#menu-btn');
let cancel = document.querySelector('#delete-btn');
let navbar = document.querySelector('.navbar');
let account = document.querySelector('.account-box');


menu.onclick = () => {
    navbar.classList.toggle('active-nav');
}

document.querySelector('#user-btn').onclick = () => {
    account.classList.toggle('active-box');
}

window.onscroll = () => {
    navbar.classList.remove('active-nav');
    account.classList.remove('active-box');
}

cancel.onclick = () => {
    window.location.href = "admin_products.php";
}