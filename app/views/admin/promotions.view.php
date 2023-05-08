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
        <div class="dashboard-header">
            <div class="d-flex flex-row align-items-center justify-content-space-between w-100">
                <h1 class="display-5 mb-2">Promotions</h1>
                <a class="btn btn-primary text-uppercase" id="add-promo-button">+ Add Promotion</a>
            </div>
            <div class="mb-2 d-flex flex-row">
                <div class="tablinks display-6 fw-bold mr-4" onclick="openTab(event, 'discount')">Discount</div>
                <div class="tablinks display-6 fw-bold mr-4" onclick="openTab(event, 'free_dish')">Free Dish</div>
                <div class="tablinks display-6 fw-bold" onclick="openTab(event, 'spending_bonus')">Spending Bonus</div>
            </div>
        </div>


        <div id="promo-maindiv">
            <div id="discount" class="tabcontent">
                <div class="card-deck">
                    <?php if (isset($discount)) : ?>
                        <?php foreach ($discount as $d) : ?>
                            <div class="card <?php if (!$d->status) echo "greyed-out" ?>"
                                 data-promoid="<?= $d->promo_id ?>" data-promotype="discounts"
                                 data-discountdish="<?= $d->dish_id ?>" data-description="<?= $d->description ?>"
                                 data-title="<?= $d->title ?>"
                                 data-discount="<?= $d->discount ?>">
                                <div class="card-header">
                                    <span><?= $d->title ?></span>
                                    <span>
                                    <a href="<?= ROOT ?>/admin/promotions/delete?promoid=<?= $d->promo_id ?>"><i
                                            class="fa fa-trash"></i></a>
                                    <i class="fa fa-pencil-square-o"></i>
                                    </span>
                                </div>
                                <div class="card-body">
                                    <img src="<?= ASSETS ?>/images/promotions/<?= $d->image_url ?>"
                                         alt="<?= $d->dish_name ?>" class="img-fluid">
                                    <span class="tooltiptext">
                                        Description: <?= $d->description ?><br>
                                        Dish: <?= $d->dish_name ?><br>
                                    Discount: <?= $d->discount ?> LKR
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div id="spending_bonus" class="tabcontent">
                <div class="card-deck">
                    <?php if (isset($spending_bonus)) : ?>
                        <?php foreach ($spending_bonus as $s) : ?>
                            <div class="card <?php if (!$s->status) echo "greyed-out" ?>"
                                 data-promoid="<?= $s->promo_id ?>" data-promotype="spending_bonus"
                                 data-description="<?= $s->description ?>" data-title="<?= $s->title ?>"
                                data-spentamount="<?= $s->spent_amount ?>" data-bonusamount="<?= $s->bonus_amount ?>">
                                <div class="card-header">
                                    <span><?= $s->title ?></span>
                                    <span>
                                    <a href="<?= ROOT ?>/admin/promotions/delete?promoid=<?= $s->promo_id ?>"><i
                                            class="fa fa-trash"></i></a>
                                    <i class="fa fa-pencil-square-o"></i>
                                </span>
                                </div>
                                <div class="card-body">
                                    <img src="<?= ASSETS ?>/images/promotions/<?= $s->image_url ?>"
                                         alt="<?= $s->title ?>" class="img-fluid">
                                    <span class="tooltiptext">
                                        Description:<?= $s->description ?> LKR<br>
                                        Spent Amount: <?= $s->spent_amount ?> LKR<br>
                                    Bonus Amount: <?= $s->bonus_amount ?> LKR
                                    </span>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div id="free_dish" class="tabcontent">
                <div class="card-deck">
                    <?php if (isset($free_dish)) : ?>
                        <?php foreach ($free_dish as $f) : ?>
                            <div class="card <?php if (!$f->status) echo "greyed-out" ?>"
                                 data-promoid="<?= $f->promo_id ?>" data-promotype="free_dish"
                                 data-dish1="<?= $f->dish1_id ?>" data-dish2="<?= $f->dish2_id ?>"
                                 data-description="<?= $f->description ?>" data-title="<?= $f->title ?>">
                                <div class="card-header">
                                    <span><?= $f->title ?></span>
                                    <span>
                                    <a href="<?= ROOT ?>/admin/promotions/delete?promoid=<?= $f->promo_id ?>"><i
                                            class="fa fa-trash"></i></a>
                                    <i class="fa fa-pencil-square-o"></i>
                                </span>
                                </div>
                                <div class="card-body">
                                    <img src="<?= ASSETS ?>/images/promotions/<?= $f->image_url ?>"
                                         alt="<?= $f->dish1_name ?>" class="img-fluid">
                                    <span class="tooltiptext">
                                        Description:<?= $f->description ?><br>
                                        Dish 1: <?= $f->dish1_name ?><br>
                                        Dish 2: <?= $f->dish2_name ?><br>
                                    </span>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

        </div>

        <div id="promo-form-div" class="overlay">
            <form method="POST" action="<?= ROOT ?>/admin/promotions/add" enctype="multipart/form-data" id="promo-form">
                <div class="form-group" id="promo-type-field">
                    <label for="promo-type">Promotion Type</label>
                    <select class="form-control" id="promo-type" name="type" required>
                        <option value="" selected disabled>Select Promotion Type</option>
                        <option value="discounts">Discount</option>
                        <option value="spending_bonus">Spending Bonus</option>
                        <option value="free_dish">Free Dish</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="promo-title">Title</label>
                    <input type="text" class="form-control" id="promo-title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="promo-desc">Description</label>
                    <input type="text" class="form-control" id="promo-desc" name="description">
                </div>
                <div class="form-group">
                    <label for="promo-status">Status</label>
                    <select class="form-control" id="promo-status" name="status">
                        <option value="1">Visible</option>
                        <option value="0">Hidden</option>
                    </select>
                </div>
                <div class="form-group" id="image-input-field">
                    <label for="promo-image">Image</label>
                    <input type="file" class="form-control" id="promo-image" name="promo_image">
                </div>

                <div id="discount-form">
                    <div class="form-group">
                        <label for="dish">Dish</label>
                        <select class="form-control" id="dish" name="dish_id">
                            <option value="" selected disabled>Select Dish</option>
                            <?php foreach ($dishes as $d) : ?>
                                <option value="<?= $d->dish_id ?>"><?= $d->dish_name ?> &nbsp; (<?=$d->selling_price?> LKR)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="discountval">Discount</label><span class="d-block">
                        <input type="number" min="0" class="form-control d-inline w-75 mr-2" id="discountval" name="discount"> LKR</span>
                    </div>
                </div>
                <div id="spending_bonus-form">
                    <div class="form-group">
                        <label for="spent-amount">Spent Amount</label><span class="d-block">
                        <input type="number" min="0" class="form-control d-inline w-75 mr-2" id="spent-amount" name="spent_amount"> LKR</span>
                    </div>
                    <div class="form-group">
                        <label for="bonus-amount">Bonus Amount</label><span class="d-block">
                        <input type="number" min="0" class="form-control d-inline w-75 mr-2" id="bonus-amount" name="bonus_amount"> LKR</span>
                    </div>
                </div>
                <div id="free_dish-form">
                    <div class="form-group">
                        <label for="dish1">Dish 1</label>
                        <select class="form-control" id="dish1" name="dish1_id">
                            <option disabled value="" selected>Select Dish</option>
                            <?php foreach ($dishes as $d) : ?>
                                <option value="<?= $d->dish_id ?>"><?= $d->dish_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dish2">Dish 2</label>
                        <select class="form-control" id="dish2" name="dish2_id">
                            <option disabled value="" selected>Select Dish</option>
                            <?php foreach ($dishes as $d) : ?>
                                <option value="<?= $d->dish_id ?>"><?= $d->dish_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-space-between w-100">
                    <button type="button" class="btn btn-secondary text-uppercase fw-bold" id="cancel-button">Cancel</button>
                    <input type="submit" name="submit" class="btn btn-primary text-uppercase fw-bold" id="submit-button">
                </div>
            </form>

        </div>
    </div>
</div>

</body>

</html>
