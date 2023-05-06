<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        Feedback
    </title>

    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/admin/common.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/admin/feedback.css">

    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
</head>

<body class="dashboard">
    <?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
    <div class="dashboard-container">
        <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
        <div class="w-100 h-100 p-5">
            <div class="dashboard-header row justify-content-space-between">
                <div>

                <h1 class="display-5 mb-2">Feedback</h1>
                </div>
                <div id="search" class="form-search order-md-0 order-1 w-50">
                    <input type="text" class="form-control" placeholder="Search Feedback" id="search-field">
                    <button class="form-search-icon">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </div>

            <div id="feedback-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Rating</th>
                            <th>Description</th>
                            <th>Time Placed</th>
                            <th>Customer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($feedback_list as $f) : ?>
                            <tr data-id="<?= $f->feedback_id ?>">
                                <td><?= $f->order_id ?></td>
                                <td data-rating="<?=$f->rating?>">
                                    <?php for ($i = 0; $i < $f->rating; $i++) : ?>
                                        <span class="fa fa-star"></span>
                                    <?php endfor; ?>
                                    <?php for ($i = 0; $i < 5 - $f->rating; $i++) : ?>
                                        <span class="fa fa-star-o"></span>
                                    <?php endfor; ?>
                                </td>

                                <td><?= $f->description ?></td>
                                <td><?= $f->time_placed ?></td>
                                <td data-id="<?=$f->user_id?>"><?= $f->first_name . " " . $f->last_name ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
            </div>

        </div>
    </div>
</body>

</html>

<script>
//search
const search = document.querySelector("#search-field");
const rows = document.querySelectorAll("#feedback-table tbody tr");
search.addEventListener("keyup", (e) => {
    const term = e.target.value.toLowerCase();
    rows.forEach((row) => {
        const id = row.getAttribute("data-id");
        const order_id = row.children[0].textContent.toLowerCase();
        const rating = row.children[1].textContent.toLowerCase();
        const description = row.children[2].textContent.toLowerCase();
        const time_placed = row.children[3].textContent.toLowerCase();
        const customer = row.children[4].textContent.toLowerCase();
        if (order_id.includes(term) || rating.includes(term) || description.includes(term) || time_placed.includes(term) || customer.includes(term)) {
            row.style.display = "table-row";
        } else {
            row.style.display = "none";
        }
    });
})
//color stars gold for all 5 stars, red for 1-2 stars, yellow for 3-4 stars
const stars = document.querySelectorAll("#feedback-table tbody tr td:nth-child(2) span");
stars.forEach((star) => {
    star.style.border = "none";
    const rating = star.parentElement.getAttribute("data-rating");
    if (rating == 1 || rating == 2) {
        star.style.color = "red";
    } else if (rating == 3 || rating == 4) {
        star.style.color = "rgba(92,171,9,0.78)";
    } else {
        star.style.color = "gold";
    }

})

//when click on customer name, redirect to customer page
const customers = document.querySelectorAll("#feedback-table tbody tr td:nth-child(5)");
customers.forEach((customer) => {
    customer.addEventListener("click", (e) => {
        const id = e.target.getAttribute("data-id");
        window.location.href = `${ROOT}/admin/users/profile/` + id;
    })
})

//when click on order id, redirect to order page
const orders = document.querySelectorAll("#feedback-table tbody tr td:nth-child(1)");
orders.forEach((order) => {
    order.addEventListener("click", (e) => {
        const id = e.target.parentElement.getAttribute("data-id");
        window.location.href = `${ROOT}/admin/orders/id/` + id;
    })
})
</script>

<style>
    #feedback-table tbody tr td:nth-child(1),
    #feedback-table tbody tr td:nth-child(5) {
        cursor: pointer;
    }

</style>