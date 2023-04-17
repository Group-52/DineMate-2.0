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
          }
        })
        .catch((error) => console.log(error));
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
  // navigator.serviceWorker &&
  //   navigator.serviceWorker
  //     .register(ROOT + "/service-worker.js")
  //     .then(function (registration) {
  //       console.log("Excellent, registered with scope: ", registration.scope);
  //     });
});
