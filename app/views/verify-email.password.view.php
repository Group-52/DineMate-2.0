<!DOCTYPE html>
<html lang="en">
<head>
    <?php include VIEWS . "/partials/home/head.partial.php" ?>
    <script>const email = <?= $email ?? "null" ?>;</script>
    <script src="<?= ASSETS ?>/js/verifyEmail.js"></script>
</head>

<body style="background: #FF4546">
<div class="vh-100 position-relative">
    <div class="row h-100 p-5">
        <div class="col-lg-6 col-12 p-5 h-100 d-flex align-items-center">
            <div class="col-offset-xl-2 col-xl-8 col-12">
                <a href="<?= ROOT ?>/home">
                    <img class="img-logo" src="<?= ROOT ?>/assets/images/logos/logo_Logo Red.svg" alt="DineMate Logo">
                </a>
                <h1 class="display-3 mb-1">Verify Email</h1>
                <?php if (isset($email)): ?>
                    <p class="text-center">
                        <?php if (isset($success)): ?>
                            A verification code has been sent to the following email address: <br><span
                                    class="secondary"><?= $email ?></span>
                        <?php else: ?>
                            An error occurred while sending the verification code to the following email address: <br>
                            <span
                                    class="secondary"><?= $email ?></span>
                        <?php endif ?>
                    </p>
                <?php endif ?>
                <form class="my-3" action="<?= ROOT ?>/auth/change" method="POST">
                    <div class="form-group">
                        <div class="d-flex m-3 justify-content-center align-items-center code-container">
                            <?php for ($i = 0; $i < 6; $i++): ?>
                                <input type="text" name="code-<?= $i + 1 ?>"
                                       id="code-<?= $i + 1 ?>"
                                       class="form-control d-inline verify-input m-2"
                                       maxlength="<?= 6 - $i ?>" required>
                            <?php endfor ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label text-uppercase fw-bold">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm-password" class="form-label text-uppercase fw-bold">Confirm Password</label>
                        <input type="password" name="confirm-password" id="confirm-password" class="form-control" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn text-uppercase">Change Password</button>
                    </div>
                </form>
                <div class="text-center fw-bold" id="message"></div>
                <div class="text-right">
                    <a class="link pointer" id="resend-code">Resend Code</a>
                </div>
            </div>
        </div>
        <div class="col-6 p-5 not-mobile h-100">
            <img src="<?= ROOT ?>/assets/images/login/cover.jpg" alt="Login Cover" class="img-cover">
        </div>
    </div>

    <div class="login-bg"></div>
</div>
</body>
</html>
