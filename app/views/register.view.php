<!DOCTYPE html>
<html lang="en">
<head>
    <?php include VIEWS . "/partials/home/head.partial.php" ?>
    <script src="<?= ASSETS ?>/js/register.js"></script>
</head>

<body style="background: #FF4546">
<div class="vh-100 position-relative">
    <div class="row h-100 p-5">
        <div class="col-6 p-5 h-100 d-flex align-items-center">
            <div class="col-offset-xl-2 col-xl-8 col-12">
                <a href="<?= ROOT ?>/home">
                    <img class="img-logo" src="<?= ROOT ?>/assets/images/logos/logo_Logo Red.svg" alt="DineMate Logo">
                </a>
                <h1 class="display-3 mb-3">Register with DineMate</h1>

                <?php if (isset($form) && isset($page_titles)) : ?>
                    <form class="w-100 py-2" action="" method="POST">
                        <?php for ($i = 0; $i < count($page_titles); $i++): ?>
                            <div class="register-page" data-page="<?= $i + 1 ?>">
                                <h1 class="display-4 mb-3"><?= $page_titles[$i] ?></h1>
                                <?php echo $form->htmlField($i * 2); ?>
                                <?php echo $form->htmlField($i * 2 + 1); ?>
                            </div>
                        <?php endfor; ?>
                        <div class="form-group text-center grid-2 grid-gap-2">
                            <button class="btn btn-primary btn-lg text-uppercase" id="prev-button">Previous</button>
                            <button class="btn btn-primary btn-lg text-uppercase" id="next-button">Next</button>
                            <button type="submit" class="btn btn-primary btn-lg text-uppercase" id="register-button">
                                Register
                            </button>
                        </div>
                    </form>
                <?php endif ?>

                <div class="fw-bold text-right mt-3">
                    Have an account? Login <a class="link" href="<?= ROOT ?>/auth/login">here</a>
                </div>
            </div>
        </div>
        <div class="col-6 p-5 h-100">
            <img src="<?= ROOT ?>/assets/images/login/cover.jpg" alt="Login Cover" class="img-cover">
        </div>

    </div>

    <div class="login-bg"></div>
</div>
</body>
</html>