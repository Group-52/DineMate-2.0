<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/promotions.css">
    <script src="<?= ASSETS ?>/js/admin/promotions.js"></script>
    <title>Promotions</title>
</head>

<body class="dashboard">
    <?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
    <div class="dashboard-container">
        <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
        <div class="w-100 h-100 p-5">
            <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
                <h1 class="display-3">Promotions</h1>
            </div>
            <div class="tab">
                <button class="tablinks btn btn-success" onclick="openTab(event, 'discount')">Discount</button>
                <button class="tablinks btn btn-success" onclick="openTab(event, 'free_dish')">Free Dish</button>
                <button class="tablinks btn btn-success" onclick="openTab(event, 'spending_bonus')">Spending Bonus</button>
            </div>

            <div id="discount" class="tabcontent">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Dish</th>
                            <th scope="col">Discount</th>
                            <th scope="col">Caption</th>
                            <th scope="col">Visible</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php if (isset($discount)) : ?>
                            <?php foreach ($discount as $d) : ?>
                                <tr data-promo-id="<?= $d->promo_id ?>">
                                    <td><?= $d->promo_id ?></td>
                                    <td><?= $d->dish_name ?></td>
                                    <td><?= $d->discount ?></td>
                                    <td><?= $d->caption ?></td>
                                    <td> <input type="checkbox" name="visible" id="visible" <?= $d->status == '1' ? 'checked' : '' ?> disabled> </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>
            <div id="spending_bonus" class="tabcontent">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Spent Amount</th>
                            <th scope="col">Bonus Amount</th>
                            <th scope="col">Caption</th>
                            <th scope="col">Visible</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php if (isset($spending_bonus)) : ?>
                            <?php foreach ($spending_bonus as $s) : ?>
                                <tr data-promo-id="<?= $s->promo_id ?>">
                                    <td><?= $s->promo_id ?></td>
                                    <td><?= $s->spent_amount ?></td>
                                    <td><?= $s->bonus_amount ?></td>
                                    <td><?= $s->caption ?></td>
                                    <td> <input type="checkbox" name="status" id="status" <?= $s->status == 1 ? 'checked' : '' ?> disabled></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </tbody>
                </table>


            </div>

            <div id="free_dish" class="tabcontent">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Dish 1</th>
                            <th scope="col">Dish 2</th>
                            <th scope="col">Caption</th>
                            <th scope="col">Visible</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php if (isset($free_dish)) : ?>
                            <?php foreach ($free_dish as $f) : ?>
                                <tr data-promo-id="<?= $f->promo_id ?>">
                                    <td><?= $f->promo_id ?></td>
                                    <td><?= $f->dish1_name ?></td>
                                    <td><?= $f->dish2_name ?></td>
                                    <td><?= $f->caption ?></td>
                                    <td> <input type="checkbox" name="status" id="status" <?= $f->status == 1 ? 'checked' : ''  ?> disabled></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </tbody>
                </table>

            </div>
        </div>
    </div>


</body>

</html>