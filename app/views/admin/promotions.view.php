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
            <a class="btn btn-primary" id="add-promo-button" href="">Add Promotion</a>

        </div>
        <div id="promo-tables">
            <div class="tab">
                <button class="tablinks btn" onclick="openTab(event, 'discount')">Discount</button>
                <button class="tablinks btn" onclick="openTab(event, 'free_dish')">Free Dish</button>
                <button class="tablinks btn" onclick="openTab(event, 'spending_bonus')">Spending Bonus
                </button>
            </div>
            <div id="discount" class="tabcontent">
                <div class="card-deck">
                    <?php if (isset($discount)) : ?>
                        <?php foreach ($discount as $d) : ?>
                            <div class="card <?php if (!$d->status) echo "greyedout" ?>"
                                 data-promoid="<?= $d->promo_id ?>">
                                <div class="card-header">
                                    <span><?= $d->title ?></span>
                                    <span>
                                    <a href="<?=ROOT?>/admin/promotions/delete?promoid=<?=$d->promo_id?>"><i class="fa fa-trash" data-promoid="<?= $d->promo_id ?>"></i></a>
                                    <i class="fa fa-pencil-square-o" data-promoid="<?= $d->promo_id ?>"></i>
                                    </span>
                                </div>
                                <div class="card-body">
                                    <img src="<?= ASSETS ?>/images/promotions/<?= $d->image_url ?>"
                                         alt="<?= $d->dish_name ?>" class="img-fluid">
                                    <span class="tooltiptext">
                                        Description:<?= $d->description ?><br>
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

                <?php if (isset($spending_bonus)) : ?>
                    <?php foreach ($spending_bonus as $s) : ?>
                        <div class="card" data-promoid="<?= $s->promo_id ?>">
                            <div class="card-header">
                                <span><?= $s->title ?></span>
                                <span>
                                    <i class="fa fa-trash" data-promoid="<?= $s->promo_id ?>"></i>
                                    <i class="fa fa-pencil-square-o" data-promoid="<?= $s->promo_id ?>"></i>
                                </span>
                            </div>
                            <div class="card-body">
                                <img src="<?= ASSETS ?>/images/promotions/<?= $s->image_url ?>"
                                     alt="<?= $s->dish_name ?>" class="img-fluid">
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
            <div id="free_dish" class="tabcontent">
                <?php if (isset($free_dish)) : ?>
                    <?php foreach ($free_dish as $f) : ?>
                        <div class="card" data-promoid="<?= $f->promo_id ?>">
                            <div class="card-header">
                                <span><?= $f->title ?></span>
                                <span>
                                    <i class="fa fa-trash" data-promoid="<?= $f->promo_id ?>"></i>
                                    <i class="fa fa-pencil-square-o" data-promoid="<?= $f->promo_id ?>"></i>
                                </span>
                            </div>
                            <div class="card-body">
                                <img src="<?= ASSETS ?>/images/promotions/<?= $f->image_url ?>"
                                     alt="<?= $f->dish_name ?>" class="img-fluid">
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

        <div id="promo-form" class="overlay">
            <form>
                <div class="form-group">
                    <label for="promo-type">Promotion Type</label>
                    <select class="form-control" id="promo-type">
                        <option value="0">Select Promotion Type</option>
                        <option value="discounts">Discount</option>
                        <option value="spending_bonus">Spending Bonus</option>
                        <option value="free_dish">Free Dish</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="promo-title">Title</label>
                    <input type="text" class="form-control" id="promo-title" required>
                </div>
                <div class="form-group">
                    <label for="promo-caption">Description</label>
                    <input type="text" class="form-control" id="promo-desc">
                </div>
                <div class="form-group">
                    <label for="promo-status">Status</label>
                    <select class="form-control" id="promo-status">
                        <option value="1">Visible</option>
                        <option value="0">Hidden</option>
                    </select>
                </div>

                <div id="discount-form">
                    <div class="form-group">
                        <label for="dish">Dish</label>
                        <select class="form-control" id="dish">
                            <?php foreach ($dishes as $d) : ?>
                                <option value="<?= $d->dish_id ?>"><?= $d->dish_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="discount">Discount</label>
                        <input type="number" min="0" class="form-control" id="discount" placeholder="... LKR" required>
                    </div>
                </div>
                <div id="spending_bonus-form">
                    <div class="form-group">
                        <label for="spent-amount">Spent Amount</label>
                        <input type="number" min="0" class="form-control" id="spent-amount" placeholder="... LKR"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="bonus-amount">Bonus Amount</label>
                        <input type="number" min="0" class="form-control" id="bonus-amount" placeholder="... LKR"
                               required>
                    </div>
                </div>
                <div id="free_dish-form">
                    <div class="form-group">
                        <label for="dish1">Dish 1</label>
                        <select class="form-control" id="dish1">
                            <?php foreach ($dishes as $d) : ?>
                                <option value="<?= $d->dish_id ?>"><?= $d->dish_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dish2">Dish 2</label>
                        <select class="form-control" id="dish2">
                            <?php foreach ($dishes as $d) : ?>
                                <option value="<?= $d->dish_id ?>"><?= $d->dish_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <button type="submit" name="submit" class="btn btn-primary" id="submit-button">Save</button>
                <button type="button" class="btn btn-secondary" id="cancel-button">Cancel</button>
            </form>

        </div>
    </div>
</div>

</body>

</html>