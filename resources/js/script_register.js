let cards = document.querySelectorAll(".form_container");
let circles = document.querySelectorAll(".circle");
let checkboxes = document.querySelectorAll('input[type="checkbox"]');

let formContainer_1 = document.querySelector(".step_1");

let next = document.querySelector(".next");

let previous = document.querySelector(".previous");

let currentStep = 1;
updateStep();

function updateStep() {
    if (currentStep <= 1) {
        currentStep = 1;
    }
    if (currentStep >= cards.length) {
        currentStep = cards.length;
    }

    circles.forEach((circle, i) => {
        circle.classList.remove("active");
        if (currentStep === i + 1) {
            circle.classList.add("active");
        }
    });
}

next.addEventListener("click", () => {
    console.log(next);
    currentStep++;
    updateStep();

    cards.forEach((card) => {
        if (card.classList.contains("current")) {
            card.classList.remove("current");
        } else {
            card.classList.add("current");
        }
    });
});

previous.addEventListener("click", () => {
    currentStep--;
    updateStep();

    cards.forEach((card) => {
        if (card.classList.contains("current")) {
            card.classList.remove("current");
        } else {
            card.classList.add("current");
        }
    });
});

checkboxes.forEach((checkbox) => {
    checkbox.addEventListener("change", (e) => {
        if (e.target.checked) {
            const parent = e.target.parentNode;
            const lastParent = parent.parentNode;

            lastParent.querySelector('input[type="text"]').style.display = "block";
        } else {
            const parent = e.target.parentNode;
            const lastParent = parent.parentNode;

            lastParent.querySelector('input[type="text"]').style.display = "none";
        }
    });
});

function disabledBtnContinue() {
    let allInput = formContainer_1.querySelectorAll('input');
    let next = document.querySelector('.next');
    let disabled = false;

    allInput.forEach((input) => {
        if (input.value === "") {
            disabled = true;
        }
    });

    if (disabled === true) {
        next.classList.add("disabled");
        next.disabled = true;
    } else {
        next.classList.remove("disabled");
        next.disabled = false;
    }
}

formContainer_1.querySelectorAll('input').forEach(input => {
    input.addEventListener('input', disabledBtnContinue);
});

disabledBtnContinue();