document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".chevron").forEach((chevron) => {
        chevron.addEventListener("click", () => {
          let order = chevron.parentElement;
          while (!order.classList.contains("order")) {
            order = order.parentElement;
          }
          order.classList.toggle("expanded");
        })
    });
})