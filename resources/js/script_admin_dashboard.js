import htmx from "htmx.org";

window.htmx = htmx;

const burgerBtn = document.querySelector(".burger-menu");
const menu = document.querySelector(".vertical-menu");
const overlay = document.querySelector(".overlay");
const MenuItems = document.querySelectorAll(".menu-item");
const SubMenuItems = document.querySelectorAll(".sub-item");

burgerBtn.addEventListener("click", () => {
    menu.classList.add("active");
});

overlay.addEventListener("click", () => {
    menu.classList.remove("active");
});

MenuItems.forEach((menu) => {
    menu.addEventListener("click", () => {
        MenuItems.forEach((item) => {
            item.classList.remove("active");
        });

        menu.classList.add("active");
    });
});

SubMenuItems.forEach((sub) => {
    sub.addEventListener("click", () => {
        SubMenuItems.forEach((item) => {
            item.classList.remove("active");
        });
        sub.classList.add("active");
    });
});
