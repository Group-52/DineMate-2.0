<!DOCTYPE html>
<html lang="en">

<head>
    <?php include VIEWS . "/partials/home/head.partial.php" ?>
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/items.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <script src="<?= ASSETS ?>/js/admin/items.js"></script>
</head>

<body class="dashboard">
    <?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
    <div class="dashboard-container">
        <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
        <div class="w-100 h-100 p-5">
            <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
                <h1 class="display-3">Items</h1>
                <a class="btn btn-primary text-uppercase fw-bold" href="items/create" id="add-item-button">+ Create Item</a>
            </div>
            <div>
                <!-- TODO add filters and bulk actions and actions to each item  -->
                <form action="" method="GET">
                    <div class="row">
                        <div class="form-search col-10">
                            <input type="text" class="form-control" name="query" placeholder="Search items" value="<?= $query ?? "" ?>">
                            <button class="form-search-icon" type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                        <div class="pl-2 col-2">
                            <select class="form-control" name="category">
                                <option value="">Filter Category</option>
                                <?php if (isset($categories) && is_array($categories)) : ?>
                                    <?php foreach ($categories as $category) : ?>
                                        <option value="<?= $category->category_name ?>" <?= (isset($category_name) && $category->category_name == $category_name) ? " selected" : "" ?>>
                                            <?= $category->category_name ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div id="item-table">
                <table class=" table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Unit</th>
                            <th>Category</th>
                        </tr>
                    </thead>
                    <?php if (isset($items) && !empty($items)) : ?>
                        <?php foreach ($items as $item) : ?>
                            <tr>
                                <?php foreach ($item as $col) : ?>
                                    <th><?= $col ?></th>
                                <?php endforeach ?>
                            </tr>
                        <?php endforeach ?>
                    <?php else : ?>
                        <th colspan="6" class="text-center">No Records Found</th>
                    <?php endif ?>
                </table>
            </div>
            <div id="item-form" class="overlay">
                <form action="<?= ROOT ?>/admin/items/create" method="POST">

                    <div class="form-group">
                        <label class="label" for="name">Name</label>
                        <input class="form-control" type="text" name="name" id="name">
                    </div>
                    <div class="form-group">
                        <label class="label" for="brand">Brand</label>
                        <input class="form-control" type="text" name="brand" id="brand">
                    </div>
                    <div class="form-group">
                        <label class="label" for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" cols="30" rows="10"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="label" for="unit">Unit</label>
                        <select class="form-control" name="unit" id="unit">
                            <option value="">Select Unit</option>
                            <?php if (isset($units)) : ?>
                                <?php foreach ($units as $unit) : ?>
                                    <option value="<?= $unit->unit_id ?>"><?= $unit->unit_name ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="label" for="category">Category</label>
                        <select class="form-control" name="category" id="category">
                            <option value="">Select Category</option>
                            <?php foreach ($data["categories"] as $category) : ?>
                                <option value="<?= $category->category_id ?>"><?= $category->category_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button class="btn btn-success text-uppercase fw-bold" type="submit" id="submit-button">Save Item</button>
                    <button type="button" class="btn btn-secondary" id="cancel-button">Cancel</button>

                </form>
            </div>
        </div>
</body>

</html>