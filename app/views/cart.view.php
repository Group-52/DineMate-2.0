<!DOCTYPE html>
<html lang="en">

<head>
    <?php include VIEWS . "/partials/home/head.partial.php" ?>
</head>

<body class="body-min-vh-100">
<div class="wrapper">
    <?php include VIEWS . "/partials/home/navbar.partial.php"; ?>
    <div class="container my-5">
        <h1 class="display-4">My Cart</h1>
        <table id="cart-table" class="table cart"></table>
    </div>
    <div class="text-center">
        <button class="btn btn-primary text-uppercase mr-2" id="clear-cart-btn">Clear Cart</button>
        <button class="btn btn-primary text-uppercase" id="checkout-btn">Checkout</button>
    </div>
</div>
<?php include VIEWS . "/partials/home/footer.partial.php"; ?>
<script src="<?php echo ASSETS . "/js/cart.js" ?>"></script>
</body>
</html>