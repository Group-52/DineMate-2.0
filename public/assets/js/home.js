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
});
