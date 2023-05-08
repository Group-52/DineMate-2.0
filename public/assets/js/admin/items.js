document.addEventListener('DOMContentLoaded', () => {

    const addButton = document.querySelector('#add-item-button');
    const form = document.querySelector('#item-form');
    const table = document.querySelector('#item-table');
    const submitButton = document.querySelector('#submit-button');
    const cancelButton = document.querySelector('#cancel-button');


    const category = document.querySelector('select[name="category"]');
    category.onchange = function () {
        if (category.value === 'All') {
            window.location.href = `${ROOT}/admin/items`;
        }
        this.form.submit();
    }

    const formClose = () => {
        form.querySelector('form').reset();
        form.style.display = 'none';
        table.style.filter = 'blur(0)';
        addButton.style.display = 'block';
    }

    // make form visible when add button is clicked
    addButton.addEventListener('click', (e) => {
        e.preventDefault();
        form.style.display = 'block';
        table.style.filter = 'blur(5px)';
        // focus on first input
        form.querySelector('input').focus();
        // make add button invisible
        addButton.style.display = 'none';
    });

    // make form invisible when cancel button is clicked
    cancelButton.addEventListener('click', formClose);

    document.querySelectorAll(".item-delete").forEach((deleteButton) => {
        deleteButton.onclick = () => {
            const itemId = deleteButton.dataset.id;
            fetch(`${ROOT}/api/items/delete/${itemId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
                .then(response => response.json())
                .then(result => {
                    if (result?.status === "success") {
                        deleteButton.parentElement.parentElement.remove();
                        new Toast("fa-solid fa-check", "#28a745", "Deleted", "Item has been deleted", false, 3000);
                    } else {
                        new Toast("fa-solid fa-times", "#dc3545", "Error", "Item could not be deleted", false, 3000);
                    }
                })
                .catch(error => {
                    new Toast("fa-solid fa-times", "#dc3545", "Error", "Item could not be deleted", false, 3000);
                })
        }
    })
    document.querySelectorAll('.edit-icon').forEach((editIcon) => {
        //redirect to edit page
        editIcon.onclick = () => {
            const itemId = editIcon.dataset.id;
            window.location.href = `${ROOT}/admin/items/edit/${itemId}`;
        };
    })
});