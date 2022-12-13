<?php include "partials/dashboard.header.php" ?>
<form action="" method="POST">
    <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
        <h1 class="display-4"><a class="link" href="<?= ROOT ?>/admin/items">Items</a> > Create Item</h1>
        <button class="btn btn-success text-uppercase fw-bold" type="submit">Save Item</button>
    </div>
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
        <label class="label" for="measure">Measure</label>
        <input class="form-control" type="text" name="measure" id="measure">
    </div>
    <div class="form-group">
        <label class="label" for="category">Category</label>
        <select class="form-control" name="category" id="category">
            <option>Beverages</option>
            <option>Bread</option>
            <option>Canned Goods</option>
            <option>Dairy</option>
            <option>Frozen Foods</option>
            <option>Meat</option>
            <option>Produce</option>
            <option>Snacks</option>
        </select>
    </div>
</form>

<?php include "partials/dashboard.footer.php" ?>
