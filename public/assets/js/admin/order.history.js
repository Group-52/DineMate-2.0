document.addEventListener('DOMContentLoaded', function () {
    //Make all the table rows links
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        row.addEventListener('click', () => {
            window.location.href = `${ROOT}/admin/orders/id/` + row.getAttribute('data-order-id');
        });
    });

});