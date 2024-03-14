(() => {
  const $header = document.querySelector(".header");
  const $open = document.querySelector("#open-header");
  const $close = document.querySelector("#close-header");

  $open.addEventListener("click", () => {
    $header.classList.add("active");
  });

  $close.addEventListener("click", () => {
    $header.classList.remove("active");
  });

  window.addEventListener("scroll", () => {
    $header.classList.remove("active");
  });


})();
