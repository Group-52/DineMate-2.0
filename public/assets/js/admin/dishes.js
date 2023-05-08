document.addEventListener('DOMContentLoaded', () => {

    // get all the elements
    const addButton = document.querySelector('#add-dish-button');
    const formdiv = document.querySelector('#dish-add-formdiv');
    const form = document.querySelector('#dish-add-formdiv form');
    const carddeck = document.querySelector('.card-deck');
    const submitButton = document.querySelector('#submit-button');
    const cancelButton = document.querySelector('#cancel-button');
    const cards = document.querySelectorAll('.card');
    const trashicons = document.querySelectorAll('.fa-trash');
    const pencilicons = document.querySelectorAll('.fa-pencil-square-o');
    const delpopup = document.querySelector('#delete-popup');
    const confirmdel = document.querySelector('#confirm');
    const canceldel = document.querySelector('#cancel');


    // make form visible when add button is clicked
    addButton.addEventListener('click', (event) => {
        event.preventDefault();
        formdiv.style.display = 'block';
        carddeck.style.filter = 'blur(5px)';
        //make card deck unclickable
        carddeck.style.pointerEvents = 'none';

        // focus on first input
        form.querySelector('input').focus();
        // make add button invisible
        addButton.style.display = 'none';
    });

    // make form invisible when cancel button is clicked
    cancelButton.addEventListener('click', () => {
        formdiv.style.display = 'none';
        carddeck.style.filter = 'blur(0)';
        addButton.style.display = 'block';
        //make card deck clickable
        carddeck.style.pointerEvents = 'auto';
        //if hidden input field with name id exists remove it
        if (form.querySelector('input[name="id"]')) {
            form.querySelector('input[name="id"]').remove();
            //change the text of submit button
            submitButton.innerHTML = 'Save';
            form.action = `${ROOT}/admin/dishes/addDish`;
            //show the image field
            form.querySelector('input[name="fileToUpload"]').style.display = 'block';
            form.querySelector('label[for="fileToUpload"]').style.display = 'block';
            //make it required
            form.querySelector('input[name="fileToUpload"]').setAttribute('required', 'required');
        }
        //reset the form
        form.reset();
    });

    //when clicked on trash icon ask the user for confirmation and then delete the dish
    trashicons.forEach((trashicon) => {
        trashicon.addEventListener('click', (event) => {
            event.preventDefault();
            const id = trashicon.closest('.card').getAttribute('data-dish-id');
            const name = trashicon.closest('.card').dataset.name;
            delpopup.setAttribute('data-id', id);
            delpopup.querySelector('span').innerHTML = name;
            delpopup.style.display = 'block';
            delpopup.style.top = `${event.pageY}px`;
        });
    });
    canceldel.addEventListener('click', () => {
        delpopup.style.display = 'none';
    });
    confirmdel.addEventListener('click', () => {
        const id = delpopup.getAttribute('data-id');
        delpopup.style.display = 'none';
        fetch(`${ROOT}/api/dishes/delete`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({id: id})
        })
            .then(response => response.json())
            .then((data) => {
                console.log(data);
                // remove the card from the page
                document.querySelector(`.card[data-dish-id="${id}"]`).remove();
            })
            .catch((error) => {
                console.log(error);
            });
    });

    // when clicked on pencil icon make the form visible and fill it with the data of the dish
    pencilicons.forEach(p => {
        p.addEventListener('click', (event) => {
            carddeck.style.filter = 'blur(5px)';
            //make card deck unclickable
            carddeck.style.pointerEvents = 'none';
            let card = p.closest('.card');
            let id = card.getAttribute('data-dish-id');
            let name = card.getAttribute('data-name');
            let description = card.getAttribute('data-description');
            let prep_time = parseFloat(card.getAttribute('data-prep-time'));
            let net_price = parseFloat(card.getAttribute('data-net-price'));
            let selling_price = parseFloat(card.getAttribute('data-selling-price'));
            let veg = card.getAttribute('data-veg');
            let image_url = card.getAttribute('data-image-url');

            formdiv.style.display = 'block';
            addButton.style.display = 'none';
            submitButton.innerHTML = 'Update';

            // focus on first input
            form.querySelector('input').focus();

            //append a hidden input field with name id
            let idInput = document.createElement('input');
            idInput.setAttribute('type', 'hidden');
            idInput.setAttribute('name', 'id');
            idInput.setAttribute('value', id);
            form.appendChild(idInput);

            form.action = `${ROOT}/admin/dishes/update`;

            //fill the form with the data
            form.querySelector('input[name="name"]').value = name;
            form.querySelector('input[name="description"]').value = description;
            form.querySelector('input[name="preptime"]').value = prep_time;
            form.querySelector('input[name="netprice"]').value = net_price;
            form.querySelector('input[name="sellprice"]').value = selling_price;
            if (veg=='1') form.querySelector('input[name="veg"]').checked = true;

            //hide the image field
            form.querySelector('input[name="fileToUpload"]').style.display = 'none';
            form.querySelector('label[for="fileToUpload"]').style.display = 'none';
            //make it not required
            form.querySelector('input[name="fileToUpload"]').removeAttribute('required');


        });


    });


    //search
    let searchField = document.querySelector('#search-field');
    searchField.addEventListener('keyup', (event) => {
        let searchValue = searchField.value;
        cards.forEach((card) => {
            let name = card.getAttribute('data-name');
            if (name.toLowerCase().includes(searchValue.toLowerCase())) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });

});
