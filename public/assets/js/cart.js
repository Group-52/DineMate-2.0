document.addEventListener("DOMContentLoaded", () => {
  let cart = [];

  /**
   * Get total price of cart
   * @param cart Cart items
   * @returns {number} Total price
   */
  const getTotalPrice = (cart) => {
    let total = 0;
    cart.forEach((item) => {
      total += item["selling_price"] * item["quantity"];
    });
    return total;
  };

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
        }
      })
      .catch((error) => console.log(error));
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
          getCart();
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
          <button class="cart-qty-btn" type="button" ${
            item["quantity"] >= 10 ? "disabled" : ""
          } data-id="${item["dish_id"]}">+</button>
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
    fetch(`${ROOT}/api/cart/all`)
      .then((res) => res.json())
      .then((data) => {
        cart = data["cart_items"];
        updateButtonState();
        const cartTable = document.getElementById("cart-table");
        const cartCount = document.getElementById("cart-count");
        if (data.status === "success" && cartTable && cartCount) {
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
          if (cart.length > 0) {
            cartTable.innerHTML += `
            <tr class="display-6" id="cart-total">
              <td class="not-mobile"></td>
              <td class="text-right">Total</td>
              <td colspan="2"></td>
              <td class="fw-bold secondary">LKR ${getTotalPrice(cart)}</td>
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
      });
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
