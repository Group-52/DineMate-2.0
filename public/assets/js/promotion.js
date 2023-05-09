// Promotions
let promotionBar = document.querySelector(".promotion-bar");
let promotionTitle = document.querySelector(".promotion-title");
let promotionPrice = document.querySelector(".promotion-price");
let progressBar = document.querySelector(".progress-bar");
const updatePromotionBar = () => {
  fetch(`${ROOT}/api/promotions/spendingBonusDetails`)
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "success") {
        const promotion = data.promotion;
        if (promotion) {
          promotionBar.classList.remove("d-none");
          promotionTitle.innerText = "Spending Bonus"
          promotionPrice.innerText = "LKR " + data['sub_total'] + " / LKR " + data['spent_amt'];
          progressBar.style.width = Math.min((data['sub_total'] / data['spent_amt']), 1) * 100 + "%";
          if (data['sub_total'] >= data['spent_amt']) {
            progressBar.classList.add("complete");
          } else {
            progressBar.classList.remove("complete");
          }
        }

        promotionBar.onclick = () => {
          window.location.href = `${ROOT}/promotion/id/${data.promotion.promo_id}`;
        }
      }
    })
    .catch((error) => console.log(error));
}

if(promotionBar && promotionTitle && promotionPrice && progressBar)
  updatePromotionBar();