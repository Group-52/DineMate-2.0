document.addEventListener("DOMContentLoaded", () => {
  let cart = [];
  let promo = null;

  const getTotalPrice = (cart) => {
    let discount = 0;
    let total = 0;
    let dish1Count = 0;
    let dish2Count = 0;
    cart.forEach((item) => {
      if (promo && promo.promotion && promo.promotion.promo_id !== 1) {
        if (promo["promotion_type"] === "Discounts") {
          if (promo["promotion"]["dish_id"] === item["dish_id"]) {
            discount += promo['discount'] * item['quantity'];
          }
        } else if (promo["promotion_type"] === "Buy 1 Get 1 Free") {
          if (promo["promotion"]["dish1_id"] === item["dish_id"]) {
            dish1Count += item["quantity"];
          } else if (promo["promotion"]["dish2_id"] === item["dish_id"]) {
            dish2Count += item["quantity"];
          }
        }
      }
      total += item["selling_price"] * item["quantity"];
    })
    if (promo && promo["promotion_type"] === "Buy 1 Get 1 Free") {
      if (promo["promotion"]["dish1_id"] === promo["promotion"]["dish2_id"]) {
        discount += Math.floor((dish1Count + dish2Count) / 2) * promo["discount"];
      } else {
        discount += Math.min(dish1Count, dish2Count) * promo["discount"];
      }
    }
    if (promo && promo["promotion_type"] === "Spending Bonus") {
      if (total >= promo["promotion"]["spent_amount"]) {
        discount += promo["promotion"]["bonus_amount"];
      }
    }
    return { discount, total };
  }

  /**
   * Get cart items
   * @param e Event
   */
  const handleClickDelete = (e) => {
    const id = e.target.dataset.id;
    fetch(`${ROOT}/api/cart/delete`, {
      method: "POST",
      body: JSON.stringify({ id }),
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.status === "success") {
          getCart();
          new Toast("fa-solid fa-check-circle", "green", "Success", "Item removed from cart", false, 3000);
          updatePromotionBar();
        } else {
          new Toast("fa-solid fa-exclamation-circle", "red", "Error", "Item could not be removed from cart", false, 3000);
        }
      })
      .catch((error) =>
        new Toast("fa-solid fa-exclamation-circle", "red", "Error", "Item could not be removed from cart", false, 3000)
      );
  };

  /**
   * Update cart quantity
   * @param e Event
   */
  const handleClickQty = (e) => {
    const id = e.target.dataset.id;
    const field = e.target.parentElement.querySelector(".cart-qty");
    const qty = parseInt(field.value) + (e.target.innerHTML === "+" ? 1 : -1);
    fetch(`${ROOT}/api/cart/update`, {
      method: "POST",
      body: JSON.stringify({ id, qty }),
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.status === "success") {
          updatePromotionBar();
          getCart();
        } else {
          new Toast("fa-solid fa-exclamation-circle", "red", "Error", data.message ?? "Could not update dish quantity", false, 3000);
        }
      })
      .catch((error) => console.log(error));
  };

  /**
   * Generate cart table
   * @param cart Cart items
   * @returns {string} HTML string
   */
  const generateCart = (cart) => {
    let result;
    if (cart.length === 0) {
      result = `<th colSpan="6" class="text-center">Cart is Empty</th>`;
    } else {
      result = cart.map(
        (item) =>
          `
          <tr>
          <td class="not-mobile td-img"><img src="${ASSETS}/images/dishes/${
            item["image_url"]
          }"
            alt="${item["dish_name"]}"></td>
          <td>${item["dish_name"]}</td>
          <td>LKR ${item["selling_price"]}</td>
          <td>
          <button class="cart-qty-btn" type="button" ${
            item["quantity"] <= 1 ? "disabled" : ""
          } data-id="${item["dish_id"]}">-</button>
          <input class="cart-qty" type="number" step="1" min="1" max="10" value="${
            item["quantity"]
          }" readonly>
          <button class="cart-qty-btn" type="button" data-id="${item["dish_id"]}">+</button>
          </td>
          <td class="fw-bold">LKR ${
            item["selling_price"] * item["quantity"]
          }</td>
          <td class="cart-trash-icon">
              <i class="fa-solid fa-trash cart-delete p-1 pointer" data-id="${
                item["dish_id"]
              }"></i>
          </td>
          </tr>
          `
      );
      result = result.join("");
    }
    return result;
  };

  /**
   * Get cart items
   */
  const getCart = () => {
    const cartFetch = fetch(`${ROOT}/api/cart/all`)
      .then((res) => res.json())
      .then((data) => {
        return data;
      })
      .catch((error) => console.log(error));

    const promoFetch = fetch(`${ROOT}/api/promotions/details`)
      .then((res) => res.json())
      .then((data) => {
        return data;
      })
      .catch((error) => console.log(error));

    Promise.all([cartFetch, promoFetch]).then((values) => {
      const cartData = values[0];
      const promoData = values[1];
      cart = cartData["cart_items"];
      promo = promoData;
      updateButtonState();
      const cartTable = document.getElementById("cart-table");
      const cartCount = document.getElementById("cart-count");
      if (cartData.status === "success" && cartTable && cartCount) {
        cartTable.innerHTML = `
          <thead>
          <tr>
            <th class="not-mobile"></th>
            <th>Item</th>
            <th>Unit Price</th>
            <th>Qty</th>
            <th>Price</th>
            <th class="cart-trash-icon"></th>
          </tr>
          </thead>
          `;
        cartTable.innerHTML += generateCart(cart);
        const {discount, total} = getTotalPrice(cart);
        if (cart.length > 0) {
          cartTable.innerHTML += `
            <tr class="fs-4" id="cart-sub-total">
              <td class="not-mobile"></td>
              <td class="text-right">Subtotal</td>
              <td colspan="2"></td>
              <td class="fw-bold secondary">LKR ${total}</td>
              <td class="cart-trash-icon"></td>
            `;
          if (promo && promo.promotion.promo_id !== 1) {
            cartTable.innerHTML += `
              <tr class="fs-4" id="cart-discount">
                <td class="not-mobile"></td>
                <td class="text-right"><a class="link" href="${ROOT}/promotion/id/${promo.promotion.promo_id}">Discount</a></td>
                <td colspan="2"></td>
                <td class="fw-bold secondary">LKR ${discount}</td>
                <td class="cart-trash-icon"></td>
              `;
          } else {
            cartTable.innerHTML += `
            <tr class="fs-4" id="cart-discount">
              <td class="not-mobile"></td>
              <td class="text-right">Discount</td>
              <td colspan="2"></td>
              <td class="fw-bold secondary">LKR ${discount}</td>
              <td class="cart-trash-icon"></td>
            `;
          }
          cartTable.innerHTML += `
            <tr class="display-6" id="cart-total">
              <td class="not-mobile"></td>
              <td class="text-right">Total</td>
              <td colspan="2"></td>
              <td class="fw-bold secondary">LKR ${total - discount}</td>
              <td class="cart-trash-icon"></td>
            `;
        }
        cartCount.innerHTML = cart.length.toString();

        [...document.getElementsByClassName("cart-delete")].forEach(
          (button) => {
            button.onclick = handleClickDelete;
          }
        );
        [...document.getElementsByClassName("cart-qty-btn")].forEach(
          (button) => {
            button.onclick = handleClickQty;
          }
        );
      }

    })
  };

  getCart();

  const checkoutBtn = document.getElementById("checkout-btn");
  const clearCartBtn = document.getElementById("clear-cart-btn");

  const updateButtonState = () => {
    if (cart.length === 0) {
      checkoutBtn.disabled = true;
      clearCartBtn.disabled = true;
    } else {
      checkoutBtn.disabled = false;
      clearCartBtn.disabled = false;
    }
  }

  checkoutBtn.onclick = () => {
    window.location.href = `${ROOT}/checkout`;
  }
  clearCartBtn.onclick = () => {
    window.location.href = `${ROOT}/cart/clear`;
  }
});
