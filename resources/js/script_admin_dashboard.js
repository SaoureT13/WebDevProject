import htmx from "htmx.org";

window.htmx = htmx;

const burgerBtn = document.querySelector(".burger-menu");
const menu = document.querySelector(".vertical-menu");
const overlay = document.querySelector(".overlay");
const MenuItems = document.querySelectorAll(".menu-item");
const SubMenuItems = document.querySelectorAll(".sub-item");
const modal = document.getElementById("modal");
const btn = document.getElementById("modalButton");
const span = document.getElementsByClassName("close-button")[0];
const reloadBtn = document.querySelector(".reload-btn");
const selects = document.querySelectorAll("select");

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

btn.onclick = function () {
    modal.style.display = "block";
};

span.onclick = function () {
    modal.style.display = "none";
};

window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
};

// reloadBtn.addEventListener("click", (e) => {
//     e.preventDefault();

//     selects.forEach((select) => {
//         select.querySelectorAll("option").forEach((option, i) => {
//             if (i === 0) {
//                 option.selected = true;
//             }
//         });
//     });
// });
