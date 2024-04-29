import './bootstrap';
import htmx from "htmx.org";

window.htmx = htmx;

const burgerButton = document.querySelector('.burger_menu')
const menu = document.querySelector('.menu')
const open_modal = document.querySelector(".new_request");
const modal = document.querySelector("#myModal");
const close_modal = document.querySelector(".close");


burgerButton.addEventListener('click', e => {
    e.preventDefault()
    menu.classList.toggle('active')

    if (menu.classList.contains('active')) {
        burgerButton.innerHTML = '<ion-icon name="close-outline"></ion-icon>'
    } else {
        burgerButton.innerHTML = '<ion-icon name="menu-outline"></ion-icon>'
    }
})


open_modal.addEventListener("click", (e) => {
    e.preventDefault()
    modal.classList.add("active");
});

close_modal.addEventListener("click", (e)=>{
    e.preventDefault()
    modal.classList.remove("active");
})

modal.addEventListener("click", (e) => {
    if (e.target.id === "myModal") {
        modal.classList.remove("active");
    }
})
