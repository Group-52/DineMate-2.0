<!DOCTYPE html>
<html lang="en">

<head>
    <?php include VIEWS . "/partials/home/head.partial.php" ?>
</head>

<body style="background: #FF4546">
<div class="vh-100 position-relative">
    <div class="row h-100 p-5">
        <div class="col-6 p-5 h-100 d-flex align-items-center">
            <div class="col-offset-xl-2 col-xl-8 col-12">
                <a href="<?= ROOT ?>/home">
                    <img class="img-logo" src="<?= ROOT ?>/assets/images/logos/logo_Logo Red.svg" alt="DineMate Logo">
                </a>
                <h1 class="display-3 mb-1">Login with DineMate</h1>
                <?php if (isset($form)) : ?>
                    <?php $form->render(); ?>
                <?php endif; ?>
                <div class="fw-bold text-right mt-3">
                    Forgot <a class="link" href="#">Password</a>?
                </div>
                <div class="fw-bold text-right mt-3">
                    Don't have an account? <a class="link" href="<?= ROOT ?>/auth/register">Register</a>
                </div>
            </div>
        </div>
        <div class="col-6 p-5 h-100">
            <img src="<?= ROOT ?>/assets/images/login/cover.jpg" alt="Login Cover" class="img-cover">
        </div>
    </div>

    <div class="login-bg"></div>
</div>
<script>
   <?php if(isset($error)) : ?>
    const errorMessage = "<?= $error ?>";
    new Toast("fa-solid fa-triangle-exclamation", "red", "Error", errorMessage, true);
   <?php endif ?>
</script>
</body>
</html>
