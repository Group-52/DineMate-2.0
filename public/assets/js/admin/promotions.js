document.addEventListener("DOMContentLoaded", function (event) {
    // simulate click on first tab
    document.querySelector(".tablinks").click();

    const addButton = document.querySelector('#add-promo-button');
    const form = document.querySelector('#promo-form');
    const table = document.querySelector('#promo-tables');
    const submitButton = document.querySelector('#submit-button');
    const cancelButton = document.querySelector('#cancel-button');
    const discountForm = document.getElementById('discount-form');
    const spendingBonusForm = document.getElementById('spending_bonus-form');
    const freeDishForm = document.getElementById('free_dish-form');

    // make form visible when add button is clicked
    addButton.addEventListener('click', (event) => {
        event.preventDefault();
        form.style.display = 'block';
        table.style.filter = 'blur(5px)';

        // focus on first input
        form.querySelector('input').focus();
        // make add button invisible
        addButton.style.display = 'none';
    });
    // make form invisible when submit button is clicked
    submitButton.addEventListener('click', () => {
        form.style.display = 'none';
        table.style.filter = 'blur(0)';

        // make add button visible
        addButton.style.display = 'block';
    });

    // make form invisible when cancel button is clicked
    cancelButton.addEventListener('click', () => {
        form.style.display = 'none';
        table.style.filter = 'blur(0)';
        addButton.style.display = 'block';
    });

    // To show the correct form when the promo type is selected
    document.getElementById("promo-form").addEventListener("change", function () {
        var promoType = document.getElementById("promo-type").value;

        // hide all forms
        discountForm.style.display = "none";
        spendingBonusForm.style.display = "none";
        freeDishForm.style.display = "none";
        
        if (promoType === "discounts") {
            discountForm.style.display = "block";
        } else if (promoType === "spending_bonus") {
            spendingBonusForm.style.display = "block";
        } else if (promoType === "free_dish") {
            freeDishForm.style.display = "block";
        }
    });

});


function openTab(evt, divName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(divName).style.display = "block";
    evt.currentTarget.className += " active";
}




