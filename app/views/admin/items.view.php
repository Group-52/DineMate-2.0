<!DOCTYPE html>
<html lang="en">

<head>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <script src="<?= ASSETS ?>/js/admin/items.js"></script>
</head>

<body class="dashboard">
    <?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
    <div class="dashboard-container">
        <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
        <div class="w-100 h-100">
            <div class="p-5">
            <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
                <h1 class="display-5 mb-2">Items</h1>
                <a class="btn btn-primary text-uppercase fw-bold" href="items/create" id="add-item-button">+ Create Item</a>
            </div>
            <div>
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
                                <?php if (isset($categories) && is_array($categories)) : ?>
                                    <option value="All" selected>All Categories</option>
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
<!--                            <th>#</th>-->
                            <th>Name</th>
                            <th>Description</th>
                            <th>Unit</th>
                            <th>Category</th>
                            <th></th>
                        </tr>
                    </thead>
                    <?php if (!empty($items)) : ?>
                        <?php foreach ($items as $item) : ?>
                            <tr data-id="<?=$item->item_id?>">
                                <th> <?= $item->item_name ?> </th>
                                <th> <?= $item->description ?> </th>
                                <th> <?= $item->units_name ?> </th>
                                <th> <?= $item->category_name?> </th>
                                <th> <i class="fa-solid fa-trash item-delete p-1 pointer" data-id="<?= $item->item_id ?>"></i> </th>
                                <th> <i class="fa fa-pencil-square-o edit-icon p-1 pointer" data-id="<?= $item->item_id ?>"></i> </th>
                            </tr>
                        <?php endforeach ?>
                    <?php else : ?>
                        <th colspan="6" class="text-center">No Records Found</th>
                    <?php endif ?>
                </table>
            </div>
            <div id="item-form" class="overlay">
                <form action="<?= ROOT ?>/admin/items/create" method="POST" enctype="multipart/form-data">

                    <div class="form-group">
                        <label class="label required" for="name">Name</label>
                        <input class="form-control" type="text" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label class="label" for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" cols="30" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="label required" for="unit">Unit</label>
                        <select class="form-control" name="unit" id="unit" required>
                            <option value="">Select Unit</option>
                            <?php if (isset($units)) : ?>
                                <?php foreach ($units as $unit) : ?>
                                    <option value="<?= $unit->unit_id ?>"><?= $unit->unit_name ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="label required" for="category">Category</label>
                        <select class="form-control" name="category" id="category" required>
                            <option value="">Select Category</option>
                            <?php if (isset($categories)) : ?>
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?= $category->category_id ?>"><?= $category->category_name ?></option>
                            <?php endforeach; ?>
                            <?php endif?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="item-image" class="label required">Upload Image</label>
                        <input type="file" name="item-image" id="item-image" class="form-control" required>
                    </div>
                    <div class="d-flex justify-content-space-between">
                        <button type="button" class="btn btn-secondary text-uppercase fw-bold" id="cancel-button">Cancel</button>
                        <button class="btn btn-primary text-uppercase fw-bold" type="submit" id="submit-button">Save Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    let items = <?= json_encode($items) ?>;
    let namefield = document.getElementById("name");
    namefield.addEventListener('change', (e) => {
        let name = e.target.value;
        let item = items.find(item => item.item_name.toLowerCase() == name.toLowerCase());
        if (item) {
            new Toast("fa-solid fa-exclamation-circle", "red", "Error", "Item with same name exists", false, 3000);
            namefield.value = "";
        }
    })
</script>