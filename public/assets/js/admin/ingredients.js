document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".card").forEach((c) => {
        c.addEventListener("click", (e) => {
            let dishid = c.getAttribute("data-dish-id");
            let url = `${ROOT}/admin/ingredients/?d=${dishid}`;
            //     redirect to ingredients page
            window.location.href = url;
        });
    });
});