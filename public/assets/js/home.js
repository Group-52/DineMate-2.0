document.addEventListener("DOMContentLoaded", () => {
  // Toggle sidebar
  const sidebar = document.getElementById("sidebar");
  const sidebarOpen = document.getElementById("sidebar-open");
  const sidebarClose = document.getElementById("sidebar-close");
  if (sidebar && sidebarOpen && sidebarClose) {
    const sidebarState = localStorage.getItem("sidebarState") || "closed";
    sidebar.classList.add(sidebarState);
    sidebarOpen.onclick = () => {
      sidebar.classList.add("open");
      sidebar.classList.remove("closed");
      localStorage.setItem(
        "sidebarState",
        sidebar.classList.contains("open") ? "open" : "closed"
      );
    };
    sidebarClose.onclick = () => {
      sidebar.classList.add("closed");
      sidebar.classList.remove("open");
      localStorage.setItem(
        "sidebarState",
        sidebar.classList.contains("open") ? "open" : "closed"
      );
    };
  }

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
  searchField.onkeyup = () => {
    const query = searchField.value;
    if (query.length > 0) {
      searchContainer.classList.add("open");
      fetch(`${ROOT}/api/dishes/search?name=${query}`)
        .then((res) => res.json())
        .then((data) => {
          if (data.status === "success") {
            searchResults.innerHTML = "";
            data.dishes.forEach((dish) => {
              searchResults.innerHTML += `
              <div class="col-lg-6 col-12">
              <a href='${ROOT}/dish/id/${dish.dish_id}' class='card-link'>
              <div class='menu-item-card horizontal rounded-sm shadow'>
              <div class='card-img-wrapper'>
              <img src='${ASSETS}/images/dishes/${
                dish.image_url
              }' class='card-img' alt='${dish.dish_name}'>
              </div>
              <div class='card-body'>
              <h2 class='card-title'>${dish.dish_name}</h2>
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
      searchResults.innerHTML = "";
    }
  };

  modalClose.onclick = () => {
    searchContainer.classList.remove("open");
    searchResults.innerHTML = "";
    searchField.value = "";
  };
});
