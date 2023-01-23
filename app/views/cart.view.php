<!DOCTYPE html>
<html lang="en">

<?php include VIEWS . "/partials/home/head.partial.php" ?>
<body>
<?php include VIEWS . "/partials/home/navbar.partial.php"; ?>
<div class="container mt-3">
    <h1 class="display-4">Cart</h1>
    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>Item Name</th>
            <th>Unit Price</th>
            <th>Count</th>
            <th>Price</th>
            <th></th>
        </tr>
        </thead>
        <?php if (isset($cart_items) && !empty($cart_items)) : ?>
            <?php foreach ($cart_items as $item) : ?>
                <tr>
                    <td><img src="<?php echo ASSETS . "/images/dishes/" . $item->image_url ?>" alt="" width="100"></td>
                    <td><?= $item->dish_name ?></td>
                    <td><?= $item->selling_price ?></td>
                    <td><?= $item->quantity ?></td>
                    <td><?= $item->selling_price * $item->quantity ?></td>
                    <td>
                        <form action="/cart/delete" method="post">
                            <i class="fa-solid fa-trash"></i>
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php else: ?>
            <th colspan="6" class="text-center">No Records Found</th>
        <?php endif ?>
    </table>

</div>
</body>
</html>