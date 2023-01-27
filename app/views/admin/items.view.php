<!DOCTYPE html>
<html lang="en">
<head>
    <?php include VIEWS . "/partials/home/head.partial.php" ?>
</head>
<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
        <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
            <h1 class="display-3">Items</h1>
            <a class="btn btn-primary text-uppercase fw-bold" href="items/create">+ Create Item</a>
        </div>
        <div>
            <form action="" method="GET">
                <div class="row">
                    <div class="form-search col-10">
                        <input type="text" class="form-control" name="query" placeholder="Search items"
                               value="<?= $query ?? "" ?>">
                        <button class="form-search-icon" type="submit">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                    <div class="pl-2 col-2">
                        <select class="form-control" name="category">
                            <option value="">Filter Category</option>
                            <?php if (isset($categories) && is_array($categories)): ?>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category->category_name ?>"
                                        <?= (isset($category_name) && $category->category_name == $category_name) ? " selected" : "" ?>>
                                        <?= $category->category_name ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>
            </form>
        </div>
        <table class="table">
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
                        <?php foreach ($item as $col): ?>
                            <th><?= $col ?></th>
                        <?php endforeach ?>
                    </tr>
                <?php endforeach ?>
            <?php else: ?>
                <th colspan="6" class="text-center">No Records Found</th>
            <?php endif ?>
        </table>
        <script>
          const category = document.querySelector('select[name="category"]');
          category.onchange = function () {
            this.form.submit();
          }
        </script>
    </div>
</div>
</body>
</html>