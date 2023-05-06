<!DOCTYPE html>
<html lang="en">
<head>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
</head>
<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">

        <div class="banner mb-3">
            <img class="banner-bg-img"
                 src="<?= ASSETS ?>/images/home/banner.jpg"
                 alt="banner">
            <div class="banner-bg-gradient"></div>
            <h1 class="banner-text display-3">Hi <?= $_SESSION["user"]->first_name ?>!</h1>
        </div>
        <!--        --><?php
        //        show($_SESSION['user']);
        //        ?>
        <h3></h3>
        <div id="parent-profile" class="p-4">
            <h3 class="d-inline">Personal Information</h3> <i class="fas mr-2 pointer fa-chevron-down"></i><br>
            <div id="profile" class="w-75 p-4">
                <form action="<?= ROOT ?>/admin/profile/personal" method="POST" class="form">
                    <div class="form-group">
                        <label class="label" for="first_name">First Name</label>
                        <input class="form-control" type="text" name="first_name" id="first_name" required
                               value="<?= $_SESSION["user"]->first_name ?>">
                    </div>
                    <div class="form-group">
                        <label class="label" for="last_name">Last Name</label>
                        <input class="form-control" type="text" name="last_name" id="last_name" required
                               value="<?= $_SESSION["user"]->last_name ?>">
                    </div>
                    <div class="form-group">
                        <label class="label" for="contact_no">Contact No</label>
                        <input class="form-control" type="text" name="contact_no" id="contact_no" required
                               value="<?= $_SESSION["user"]->contact_no ?>">
                    </div>
                    <div class="form-group">
                        <label class="label" for="email">Email</label>
                        <input class="form-control" type="text" name="email" id="email" required
                               value="<?= $_SESSION["user"]->email ?>">
                    </div>
                    <button class="btn btn-success text-uppercase fw-bold" type="submit" name="save" id="profile-submit-button">
                        Save Details
                    </button>
                </form>
            </div>
        </div>
        <div id="password-profile" class="p-4">
            <br><h3 class="d-inline">Change Password</h3> <i class="fas mr-2 pointer fa-chevron-down"></i> <br>
            <div id="password" class="w-75 p-4">
                <form action="<?= ROOT ?>/admin/profile/password" method="POST" class="form">
                    <div class="form-group">
                        <label class="label" for="password">Current Password</label>
                        <input class="form-control" type="password" name="old_password" id="password" required>
                    </div>
                    <div class="form-group">
                        <label class="label" for="new_password">New Password</label>
                        <input class="form-control" type="password" name="new_password" id="new_password" required>
                    </div>
                    <div class="form-group">
                        <label class="label" for="confirm_password">Confirm Password</label>
                        <input class="form-control" type="password" name="confirm_password" id="confirm_password" required>
                    </div>
                    <button class="btn btn-success text-uppercase fw-bold" type="submit" name="save" id="pwd-submit-button">
                        Save Password
                </form>
            </div>
        </div>
        <?php if(isset($pwd_error)): ?>
            <script>
                new Toast("fa-solid fa-exclamation-triangle", "#dc3545", "Error","<?=$pwd_error?>", false, 3000);
            </script>
        <?php elseif(isset($pwd_success)): ?>
            <script>
                new Toast("fa-solid fa-check", "#28a745", "Success", "<?=$pwd_success?>", false, 3000);
            </script>
        <?php endif; ?>

    </div>
</body>

</html>
<script>

    let profilechevron = document.querySelector('#parent-profile i');
    let profilediv = document.getElementById('profile');

    profilechevron.addEventListener('click', function () {
        if (profilediv.style.display === 'none') {
            profilechevron.classList.remove('fa-chevron-down');
            profilechevron.classList.add('fa-chevron-up');
            profilediv.style.display = 'block';
        } else {
            profilechevron.classList.remove('fa-chevron-up');
            profilechevron.classList.add('fa-chevron-down');
            profilediv.style.display = 'none';
        }
    });

    let passwordchevron = document.querySelector('#password-profile i');
    let passworddiv = document.getElementById('password');

    passwordchevron.addEventListener('click', function () {
        if (passworddiv.style.display === 'none') {
            passwordchevron.classList.remove('fa-chevron-down');
            passwordchevron.classList.add('fa-chevron-up');
            passworddiv.style.display = 'block';
        } else {
            passwordchevron.classList.remove('fa-chevron-up');
            passwordchevron.classList.add('fa-chevron-down');
            passworddiv.style.display = 'none';
        }
    });

    ['profile', 'password'].forEach(function (id) {
        document.getElementById(id).style.display = 'none';
    });
</script>