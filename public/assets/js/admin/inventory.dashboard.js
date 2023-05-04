document.addEventListener("DOMContentLoaded", () => {

    document.querySelectorAll('.card').forEach(card => {
        updatebar(card);
        //on hover increase the size of the card and display the .batches-left span
        card.addEventListener('mouseover', () => {
            card.style.transform = 'scale(1.05)';
            card.querySelector('.batches-left').style.display = 'inline-block';
        });
        //on mouseout decrease the height of the card and hide the .batches-left span
        card.addEventListener('mouseout', () => {
            card.style.transform = 'scale(1)';
            card.querySelector('.batches-left').style.display = 'none';

        });

        //redirect to the batches page
        card.querySelectorAll('.batches-left').forEach(batch => {
            batch.addEventListener('click', () => {
                window.location.href = `${ROOT}/admin/inventory/info`
            });
        })
    });

    // Update the progress bar
    function updatebar(card) {
        const progressBar = card.querySelector('.progress-bar');
        const quantitySpan = card.querySelector('.card-quantity span');
        let quantity = parseFloat(card.querySelector('.numerator').innerText);
        let maxQuantity = parseFloat(card.querySelector('.denominator').innerText.slice(1));
        if (quantity >= maxQuantity) {
            quantity = maxQuantity;
        }
        const progress = quantity / maxQuantity * 100;
        progressBar.style.width = `${progress}%`;

        let lastUpdated = card.getAttribute('data-last-updated');
        let leadTime = parseFloat(card.getAttribute('data-lead-time'));
        let bufferLevel = parseFloat(card.getAttribute('data-buffer-level'));
        let reorderLevel = parseFloat(card.getAttribute('data-reorder-level'));

        if (quantity <= bufferLevel) {
            //make the progress bar red
            progressBar.style.backgroundColor = 'red';
        } else if (quantity <= reorderLevel) {
            //make the progress bar yellow
            progressBar.style.backgroundColor = 'yellow';
        }

        let updatedSpan = card.querySelector('.not-updated');

        // Convert the timestamp value to a JavaScript Date object
        const lastUpdatedDate = new Date(lastUpdated);

        // Get the current date and time
        const currentDate = new Date();

        // Calculate the difference in milliseconds between the two dates
        const diffInMs = currentDate - lastUpdatedDate;
        let days = Math.round(diffInMs / (1000 * 60 * 60 * 24));
        if (days > 2) {
            updatedSpan.style.display = 'block';
        }

    }

    //Search bar
    const search = document.getElementById('search-field');
    search.addEventListener('keyup', (e) => {
        const searchString = e.target.value.toLowerCase();
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            const name = card.querySelector('.card-name').innerText.toLowerCase();
            if (name.includes(searchString)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        })

        //hide the category if all the cards in it are hidden
        let categories = document.querySelectorAll('.category');
        categories.forEach(category => {
            let cards = category.querySelectorAll('.card');
            let cardsArray = Array.from(cards);
            let cardsDisplayed = cardsArray.filter(card => card.style.display !== 'none');
            if (cardsDisplayed.length === 0) {
                category.style.display = 'none';
            }else{
                category.style.display = 'flex';
            }
        })
    })

});