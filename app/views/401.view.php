<!DOCTYPE html>
<html lang="en">

<head>
    <?php include VIEWS . "/partials/home/head.partial.php" ?>
</head>

<body class="vh-100 d-flex align-items-center justify-content-center">
<div class="not-found-container">
    <img src="<?= ROOT ?>/assets/images/401.svg" alt="401 Not Authorized">
    <p class="heading-2 fw-bold text-center text-uppercase mt-2">Insufficient Authorization</p>
    <p class="heading-4 text-center mt-2">You are not authorized to access the page</p>
    <a href="<?= ROOT ?>/home" class="link text-right">Go to home</a>
</div>
</body>
</html>