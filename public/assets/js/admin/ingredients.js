document.addEventListener("DOMContentLoaded", () => {

    const dishSelect = document.getElementById("dish-select");
    if (dishSelect) {
        dishSelect.addEventListener("change", (event) => {
            const dishId = event.target.value;
            if (dishId) {
                window.location.href = `${ROOT}/admin/ingredients/?d=${dishId}`;
            }
        });
    }

});