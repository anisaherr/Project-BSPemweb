let navbar = document.querySelector('.header .navbar');
let accountBox = document.querySelector('.header .account-box');

document.querySelector('#menu-btn').onclick = () =>{
   navbar.classList.toggle('active');
   accountBox.classList.remove('active');
}

document.querySelector('#user-btn').onclick = () =>{
   accountBox.classList.toggle('active');
   navbar.classList.remove('active');
}

window.onscroll = () =>{
   navbar.classList.remove('active');
   accountBox.classList.remove('active');
}

document.querySelector('#close-update').onclick = () =>{
   document.querySelector('.edit-product-form').style.display = 'none';
   window.location.href = 'admin_products.php';
}

document.querySelector('#close-update').onclick = () =>{
   document.querySelector('.add-products').style.display = 'none';
   window.location.href = 'admin_products.php';
}

function openAddProductPopup() {
   document.querySelector(".add-product-popup").style.display = "block";
 }

 function closeAddProductPopup() {
   document.querySelector(".add-product-popup").style.display = "none";
 }
 