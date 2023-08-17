import $ from "jquery";

const $contactButton = $("#contactButton");

$contactButton.on("click", function (e) {
  e.preventDefault();
  $("#contactForm").slideDown();
  $contactButton.slideUp();
});
