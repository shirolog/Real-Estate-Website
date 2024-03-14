/** @format */

(() => {
  //ヘッダーナビゲーション設定
  const $menuBtn = document.querySelector("#menu-btn .fa-bars");
  const $menu = document.querySelector(".header .navbar .flex .menu");

  $menuBtn.addEventListener("click", () => {
    $menu.classList.toggle("active");
    $menuBtn.classList.toggle("fa-times");
  });

  window.addEventListener("scroll", () => {
    $menu.classList.remove("active");
    $menuBtn.classList.remove("fa-times");
  });

  //数量の文字制限設定
  document.querySelectorAll('input[type="number"]').forEach((inputNumber) => {
    inputNumber.oninput = () => {
      if (inputNumber.value.length > inputNumber.max.length) {
        inputNumber.value = inputNumber.value.slice(0, inputNumber.max.length);
      }
    };
  });

  //contact.phpのモーダルウィンドウ設定
  const $titles = document.querySelectorAll(".faq .box-container .box h3");
  const $contents = document.querySelectorAll(".faq .box-container .box");
  const $icon = document.querySelectorAll(".faq .box-container .box h3 i");

  $titles.forEach((title, index) => {
    title.addEventListener("click", () => {
      $contents.forEach((content, boxIndex) => {
        if (index === boxIndex) {
          content.classList.toggle("active");
          title.classList.toggle("active");
          $icon[boxIndex].classList.toggle("active");
        } else {
          content.classList.remove("active");
          title.classList.remove("active");
          $icon[boxIndex].classList.remove("active");
        }
      });
    });
  });

  //view.property.phpのswiper設定

  var swiper = new Swiper(".image-container", {
    effect: "coverflow",
    grabCursor: true,
    centeredSlides: true,
    slidesPerView: "auto",
    coverflowEffect: {
      rotate: 0,
      stretch: 0,
      depth: 200,
      modifier: 1,
      slideShadows: true,
    },
    loop: true,
    pagination: {
      el: ".swiper-pagination",
    },
  });


})();
