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
            let card = p.closest('.card');
            let id = card.getAttribute('data-dish-id');
            let name = card.getAttribute('data-name');
            let description = card.getAttribute('data-description');
            let prep_time = parseFloat(card.getAttribute('data-prep-time'));
            let net_price = parseFloat(card.getAttribute('data-net-price'));
            let selling_price = parseFloat(card.getAttribute('data-selling-price'));
            let image_url = card.getAttribute('data-image-url');

            formdiv.style.display = 'block';
            addButton.style.display = 'none';
            submitButton.innerHTML = 'Update';

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

            //hide the image field
            form.querySelector('input[name="fileToUpload"]').style.display = 'none';
            form.querySelector('label[for="fileToUpload"]').style.display = 'none';
            //make it not required
            form.querySelector('input[name="fileToUpload"]').removeAttribute('required');


        });


    });


});

// <div className="card p-2" data-dish-id="<?= $d->dish_id ?>" data-name="<?= $d->dish_name ?>"
//      data-description="<?= $d->description ?>" data-prep-time="<?= $d->prep_time ?>"
//      data-net-price="<?= $d->net_price ?>" data-selling-price="<?= $d->selling_price ?>"
//      data-image-url="<?= $d->image_url ?>">
//     <div className="card-header p-1 mb-2">
//         <?= $d->dish_name ?>
//     </div>
//     <div className="card-image pb-2">
//         <img src="<?= ASSETS ?>/images/dishes/<?= $d->image_url ?>" alt="dish image">
//     </div>
//     <div className="card-text pt-1 pl-2">
//         <p><span className="dish-details">Prep Time:</span>&nbsp &nbsp<?= $d->prep_time ?> minutes</p>
//         <p><span className="dish-details">Net Price:</span>&nbsp &nbsp<?= $d->net_price ?> LKR</p>
//         <p><span className="dish-details">Selling Price:</span>&nbsp &nbsp<?= $d->selling_price ?> LKR</p>
//         <p><span className="dish-details">Description:</span>&nbsp &nbsp<?=$d->description?></p>
//     </div>
//     <span className="d-flex justify-content-space-between pt-2">
//                             <span className="p-1 mr-2">
//                             <a href="<?=ROOT?>/admin/ingredients/?d=<?=$d->dish_id?>"><i
//                                 className="fa-solid fa-plus primary"></i></a>
//                             </span>
//                             <span className="d-flex justify-content-end">
//                             <i className="fa fa-pencil-square-o px-1 pt-2"></i>
//                             <i className="fa fa-trash d-inline px-1 pt-2"></i>
//                             </span>
//                         </span>
// </div>
// <div id="dish-add-form" class="overlay">
//
//     <form method="post" enctype="multipart/form-data" action="<?= ROOT ?>/admin/dishes/addDish">
//         <div class="form-group">
//             <label for="name">Name</label>
//             <input type="text" name="name" class="form-control" required>
//         </div>
//         <div class="form-group">
//             <label for="preptime">Preparation Time</label>
//             <span class="d-block">
//                     <input type="number" name="preptime" class="form-control w-75 mr-2 d-inline" required min="0">
//                         Minutes
//                     </span>
//         </div>
//         <div class="form-group">
//             <label for="netprice">Net Price</label>
//             <span class="d-block"><input type="number" name="netprice" class="form-control d-inline w-75 mr-2"
//                                          required min="0"> LKR
//                         </span>
//         </div>
//         <div class="form-group">
//             <label for="sellprice">Selling Price</label>
//             <span class="d-block"><input type="number" name="sellprice" class="form-control d-inline w-75 mr-2"
//                                          required min="0"> LKR
//                         </span>
//         </div>
//         <div class="form-group">
//             <label for="description">Description</label>
//             <input type="text" name="description" class="form-control">
//         </div>
//         <div class="form-group">
//             <label for="fileToUpload">Select image to upload:</label>
//             <input type="file" name="fileToUpload" id="fileToUpload" class='form-control' required>
//         </div>
//         <button type="submit" name="submit" class="btn btn-primary" id="submit-button">Save</button>
//         <button type="button" class="btn btn-secondary" id="cancel-button">Cancel</button>
//     </form>
// </div>
//