(() => {
  //search.phpページのfilter-searchのオーバーレイ設定
  const $openBtn = document.querySelector("#open-filter ");
  const $filter = document.querySelector(".filter-search ");
  const $closedBtn = document.querySelector("#close-filter i");

  $openBtn.addEventListener("click", () => {
    $filter.classList.add("active");
  });

  $closedBtn.addEventListener("click", () => {
    $filter.classList.remove("active");
  });
})();
