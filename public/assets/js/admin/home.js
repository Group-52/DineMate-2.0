document.addEventListener('DOMContentLoaded', function () {

    //remove first nav-item
    document.querySelector('.nav-item').remove();

    let myroleID = document.querySelector('#myrole').innerHTML;
    let roles = {1: "Chef", 2: "General Manager", 3: "Cashier", 4: "Inventory Manager"};
    let myrole = roles[myroleID];
    let controllers = {
        "Chef": ["home", "orders", "ingredients"],
        "Cashier": ["home", "payments"],
        "Inventory Manager": ["home", "ingredients", "vendors", "inventory", "items", "purchases"]
    };
    const cards = document.querySelectorAll('.card');

    // function to set cards where user doesn't have access to opacity 0.5
    function setCards() {
        if (myrole == "General Manager") return;
        console.log(cards);
        for (let i = 0; i < cards.length; i++) {
            let controller = cards[i].getAttribute('data-controller');
            console.log(controller);
            if (!controllers[myrole].includes(controller)) {
                cards[i].addEventListener('click', function (e) {
                    e.preventDefault();
                    new Toast("fa-sharp fa-solid fa-lock", '#c41111', "Unauthorized Access", "You don't have access to this page", false, 3000);
                });
                cards[i].style.opacity = 0.4;
            }
        }
    }

    setCards();


});
