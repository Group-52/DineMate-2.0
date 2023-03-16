<!DOCTYPE html>
<html lang="en">
<head>
    <?php include VIEWS . "/partials/home/head.partial.php" ?>
</head>
<body class="body-min-vh-100">
<div class="wrapper">
    <?php include VIEWS . "/partials/home/navbar.partial.php" ?>
    <div class="banner mb-3">
        <img class="banner-bg-img"
             src="<?= ASSETS ?>/images/home/banner.jpg"
             alt="banner">
        <div class="banner-bg-gradient"></div>
        <h1 class="banner-text display-3">User Profile</h1>
    </div>
    <div class="container py-5">
        <div class="row">
            <?php if (isset($_SESSION["user"])): ?>
            <div class="col-offset-md-1"></div>
            <div class="col-md-4 col-12 p-5 mb-5">
                <ul class="d-flex h-100 display-5 justify-content-center flex-column">
                    <li><a class="link" href="<?= ROOT ?>/profile/info">Personal Info</a></li>
                    <li><a class="link" href="<?= ROOT ?>/profile/settings">Account Settings</a></li>
                </ul>
            </div>
            <div class="col-md-6 col-12">
                <?php if (isset($form)) {
                    /** @var components\Form $form */
                    $form->beginForm();
                    for ($i = 0; $i < $form->countFields(); $i++) {
                        echo $form->htmlField($i);
                        if ($i == 2 && $_SESSION["user"]->verified_email == 0) {
                            echo "<div class='mb-3'>Your email address has not been verified yet - <a class='link' href='" . ROOT . "/profile/verify'>Verify Email</a></div>";
                        }
                    }
                    echo $form->htmlButton();
                    $form->endForm();
                } ?>
                <?php endif ?>
            </div>
            <div class="col-offset-md-1"></div>
        </div>
    </div>
    <?php include VIEWS . "/partials/home/footer.partial.php" ?>
</div>
</body>
</html>