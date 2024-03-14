(() => {
  //view.property.phpのswiper設定
  swiper = new Swiper(".image-container", {
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
    on: {
      init: function () {
        swiper.slideTo(0, 0); // 初期スライドに移動
      },
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },

  });

})();
