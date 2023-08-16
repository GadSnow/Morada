const burger__menu = document.querySelector(".burger__menu");
const navbar = document.querySelector(".navbar");
const navbar__content = document.querySelector(".navbar__content");
const nav__items = document.querySelector(".nav__items");
const burger__pieces = document.querySelectorAll(".burger__piece");

let navState = false;

burger__menu.addEventListener("click", () => {
  navState = !navState;
  if (navState) {
    document.body.style.overflowY = "hidden";
  } else {
    document.body.style.overflowY = "visible";
  }
  nav__items.classList.toggle("nav__items__visible");
  navbar.classList.toggle("navbar__visible");
  navbar__content.classList.toggle("navbar__content__visible");
  burger__menu.classList.toggle("rotate");
  burger__pieces.forEach((piece, index) => {
    index += 1;
    piece.classList.toggle(`cross${index}`);
  });
});
