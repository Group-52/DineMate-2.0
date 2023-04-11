document.addEventListener("DOMContentLoaded", function (event) {
    // simulate click on first tab
    document.querySelector(".tablinks").click();

    const addButton = document.querySelector('#add-promo-button');
    const form = document.querySelector('#promo-form');
    const formdiv = document.querySelector('#promo-form-div');
    const maindiv = document.querySelector('#promo-maindiv');
    const submitButton = document.querySelector('#submit-button');
    const cancelButton = document.querySelector('#cancel-button');
    const discountForm = document.getElementById('discount-form');
    const spendingBonusForm = document.getElementById('spending_bonus-form');
    const freeDishForm = document.getElementById('free_dish-form');
    const editIcons = document.querySelectorAll('.fa-pencil-square-o');

    // make form visible when add button is clicked
    addButton.addEventListener('click', (event) => {
        event.preventDefault();
        formdiv.style.display = 'block';
        maindiv.style.filter = 'blur(5px)';

        // focus on first input
        form.querySelector('input').focus();
        // make add button invisible
        addButton.style.display = 'none';
    });

    // make form invisible when cancel button is clicked
    cancelButton.addEventListener('click', () => {
        formdiv.style.display = 'none';
        maindiv.style.filter = 'blur(0)';
        form.action = `${ROOT}/admin/promotions/add`;
        form.reset();
        discountForm.style.display = "none";
        spendingBonusForm.style.display = "none";
        freeDishForm.style.display = "none";
        document.querySelector('#promo-type-field').style.display = 'block';
        addButton.style.display = 'block';
        let tempfield = form.querySelector('#tempid')
        if (tempfield) tempfield.remove();
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

    //edit promotions
    editIcons.forEach(function (icon) {
        let card = icon.closest('.card');
        icon.addEventListener('click', function () {
            addButton.style.display = 'none';
            //gather data from card
            let promoId = card.dataset.promoid;
            let promoType = card.dataset.promotype;
            let promoTitle = card.dataset.title;
            let promoDesc = card.dataset.description;
            let promoStatus = (card.classList.contains('greyed-out')) ? 0 : 1;
            if (promoType === 'discounts') {
                var dishId = card.dataset.discountdish;
                var discount = card.dataset.discount;
            } else if (promoType === 'spending_bonus') {
                var spentAmount = card.dataset.spentamount;
                var bonusAmount = card.dataset.bonusamount;
            } else if (promoType === 'free_dish') {
                var dish1Id = card.dataset.dish1;
                var dish2Id = card.dataset.dish2;
            }
            let data = {
                promoId: promoId,
                promoType: promoType,
                promoTitle: promoTitle,
                promoDesc: promoDesc,
                promoStatus: promoStatus,
                dishId: dishId,
                discount: parseFloat(discount),
                spentAmount: parseFloat(spentAmount),
                bonusAmount: parseFloat(bonusAmount),
                dish1Id: dish1Id,
                dish2Id: dish2Id
            };
            //remove undefined values in data
            for (let key in data) {
                if (data[key] === undefined) {
                    delete data[key];
                }
            }
            // console.log(data);

            // change form action
            form.action = `${ROOT}/admin/promotions/edit`;
            // add a hidden field with promoid
            let promoIdField = document.createElement('input');
            promoIdField.type = 'hidden';
            promoIdField.name = 'promo_id';
            promoIdField.value = promoId;
            promoIdField.id = 'tempid';
            form.prepend(promoIdField);

            //prefill form with above data
            discountForm.style.display = 'none';
            spendingBonusForm.style.display = 'none';
            freeDishForm.style.display = 'none';

            document.querySelector('#promo-type').value = data.promoType;
            document.querySelector('#promo-type-field').style.display = 'none';
            document.querySelector('#promo-title').value = data.promoTitle;
            document.querySelector('#promo-desc').value = data.promoDesc;
            document.querySelector('#promo-status').value = data.promoStatus;
            if (data.promoType === 'discounts') {
                document.querySelector('#dish').value = data.dishId;
                document.querySelector('#discountval').value = data.discount;
                discountForm.style.display = 'block';
            } else if (data.promoType === 'spending_bonus') {
                document.querySelector('#spent-amount').value = data.spentAmount;
                document.querySelector('#bonus-amount').value = data.bonusAmount;
                spendingBonusForm.style.display = 'block';
            } else if (data.promoType === 'free_dish') {
                document.querySelector('#dish1').value = data.dish1Id;
                document.querySelector('#dish2').value = data.dish2Id;
                freeDishForm.style.display = 'block';
            }
            //display form and blur background
            formdiv.style.display = 'block';
            maindiv.style.filter = 'blur(5px)';
            document.querySelector('#image-input-field').style.display = 'none';

        });
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




