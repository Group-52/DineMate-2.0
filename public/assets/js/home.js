document.addEventListener("DOMContentLoaded", () => {
  // Toggle sidebar
  const sidebar = document.getElementById("sidebar");
  const sidebarOpen = document.getElementById("sidebar-open");
  if (sidebar && sidebarOpen) {
    sidebarOpen.onclick = () => {
      sidebar.classList.toggle("open");
    };
  }
  document.onclick = (e) => {
    if (
      !sidebar.contains(e.target) &&
      e.target.id !== "sidebar" &&
      e.target.id !== "sidebar-open"
    ) {
      sidebar.classList.remove("open");
    }
  };

  // Add to cart
  const addToCartButtons = document.querySelectorAll(".add-to-cart");
  const cartCount = document.getElementById("cart-count");
  addToCartButtons.forEach((button) => {
    button.onclick = () => {
      const id = button.dataset.id;
      fetch(`${ROOT}/api/cart/add`, {
        method: "POST",
        body: JSON.stringify({ id }),
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.status === "success") {
            cartCount.innerText = data["cart_count"] || 0;
            button.disabled = true;
            button.firstChild.className = "fa-solid fa-check";
            new Toast("fa-solid fa-check", "#59BB1E", "Success", "Added to cart successfully", false, 5000);
          }
        })
        .catch((error) => {
          console.log(error);
          new Toast("fa-solid fa-triangle-exclamation", "#FF4D4D", "Error", "Something went wrong", false, 5000);
        })
    };
  });

  // Search
  const searchContainer = document.getElementById("home-search");
  const searchField = document.getElementById("home-search-field");
  const searchResults = document.getElementById("home-search-results");
  const modalClose = document.getElementById("home-modal-close");
  const html = document.querySelector("html");
  if (searchField) {
    searchField.onkeyup = () => {
      const query = searchField.value;
      if (query.length > 0) {
        searchContainer.classList.add("open");
        html.style.overflow = "hidden";
        fetch(`${ROOT}/api/dishes/search?name=${query}`)
          .then((res) => res.json())
          .then((data) => {
            if (data.status === "success") {
              searchResults.innerHTML = "";
              data.dishes.forEach((dish) => {
                searchResults.innerHTML += `
              <div>
              <a href='${ROOT}/dish/id/${dish.dish_id}' class='card-link'>
              <div class='menu-item-card rounded-sm'>
              <div class='card-img-wrapper'>
              <img src='${ASSETS}/images/dishes/${
                  dish.image_url
                }' class='card-img' alt='${dish.dish_name}'>
              </div>
              <div class='card-body'>
              <h3 class='card-title'>${dish.dish_name}</h3>
              <div class='card-prices'>
              ${
                dish.old_price != null
                  ? `<span class="card-price-old">LKR ${dish.old_price}</span>`
                  : ""
              }
              <div class='card-price-new'>LKR ${dish.selling_price}</div>
              </div></div></div></a></div>
              `;
              });
            }
          })
          .catch((error) => console.log(error));
      } else {
        searchContainer.classList.remove("open");
        html.style.overflow = "";
        searchResults.innerHTML = "";
      }
    };
  }

  if (modalClose) {
    modalClose.onclick = () => {
      searchContainer.classList.remove("open");
      html.style.overflow = "";
      searchResults.innerHTML = "";
      searchField.value = "";
    };
  }

  const states = ({
    "accepted_order": {
      "from": "pending",
      "to": "accepted"
    },
    "rejected_order": {
      "from": "pending",
      "to": "rejected"
    },
    "completed_order": {
      "from": "accepted",
      "to": "completed"
    }
  });

  Object.keys(states).forEach((state) => {
    (new Socket()).receive_data(state, (data) => {
      const userId = data["user_id"];
      if (userId === USER_ID) {
        const orderId = data["order_id"];
        const orderStatusText = states[state]["to"].slice(0, 1).toUpperCase() + states[state]["to"].slice(1);
        if (state !== "rejected_order")
        {
          new Toast("fa-solid fa-check", "#59BB1E", orderStatusText, "Order #" + orderId + " has been " + states[state]["to"], false, 5000);
        } else {
          new Toast("fa-solid fa-triangle-exclamation", "#FF4D4D", orderStatusText, "Order #" + orderId + " has been " + states[state]["to"], false, 5000);
        }
      }
    })

  });


  // navigator.serviceWorker &&
  //   navigator.serviceWorker
  //     .register(ROOT + "/service-worker.js")
  //     .then(function (registration) {
  //       console.log("Excellent, registered with scope: ", registration.scope);
  //     });
});
