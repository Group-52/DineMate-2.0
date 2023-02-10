document.addEventListener("DOMContentLoaded", () => {
  const registerPages = document.querySelectorAll(".register-page");
  const pages = 3;
  let currentPage = 1;

  const nextButton = document.getElementById("next-button");
  const prevButton = document.getElementById("prev-button");
  const registerButton = document.getElementById("register-button");

  const updateDisplay = () => {
    registerPages.forEach((page) => {
      if (parseInt(page.dataset.page) === currentPage) {
        page.classList.remove("d-none");
      } else {
        page.classList.add("d-none");
      }
    });

    if (currentPage === 1) {
      prevButton.disabled = true;
      nextButton.disabled = false;

      nextButton.classList.remove("d-none");
      registerButton.classList.add("d-none");
    } else if (currentPage === pages) {
      prevButton.disabled = false;

      nextButton.classList.add("d-none");
      registerButton.classList.remove("d-none");
    } else {
      prevButton.disabled = false;
      nextButton.disabled = false;

      nextButton.classList.remove("d-none");
      registerButton.classList.add("d-none");
    }
  };

  nextButton.addEventListener("click", () => {
    currentPage = Math.min(currentPage + 1, pages);
    updateDisplay();
  });

  prevButton.addEventListener("click", () => {
    currentPage = Math.max(currentPage - 1, 1);
    updateDisplay();
  });

  updateDisplay();
});
