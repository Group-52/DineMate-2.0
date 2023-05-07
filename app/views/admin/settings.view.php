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

        <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
            <h1 class="display-5 mb-2">Settings</h1>
        </div>

        <div id="parent-general" class="p-4">
            <h3 class="d-inline">General Details</h3> <i class="fas mr-2 pointer fa-chevron-down"></i><br>
            <div id="general" class="w-75 p-4">
                <form action="<?= ROOT ?>/admin/settings/update" method="POST" class="form">
                    <div class="form-group">
                        <label class="label" for="restaurant_name">Restaurant Name</label>
                        <input class="form-control" type="text" name="restaurant_name" id="restaurant_name" required
                               value="<?= $details->restaurant_name ?>">
                    </div>
                    <div class="form-group">
                        <label class="label" for="opening_time">Opening Time</label>
                        <input class="form-control" type="time" name="opening_time" id="opening_time" required
                               value="<?= $details->opening_time ?>">
                    </div>
                    <div class="form-group">
                        <label class="label" for="closing_time">Closing Time</label>
                        <input class="form-control" type="time" name="closing_time" id="closing_time" required
                               value="<?= $details->closing_time ?>">
                    </div>
                    <div class="form-group">
                        <label class="label" for="introduction">Introduction</label>
                        <textarea class="form-control" name="introduction" id="introduction" cols="30" rows="5"
                                  required><?= $details->introduction ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="label" for="kitchen_staff">No. of Active Kitchen Staff</label>
                        <input class="form-control" type="number" name="kitchen_staff" id="kitchen_staff" required
                               value="<?= $details->kitchen_staff ?>">
                    </div>
                    <div class="form-group">
                        <label class="label" for="max_guest_bill">Maximum bill allowed for unregistered customers
                            (LKR)</label>
                        <input class="form-control" type="number" min="0" name="max_guest_bill" id="max_guest_bill"
                               required
                               value="<?= $details->max_guest_bill ?>">
                    </div>
                    <div class="form-group">
                        <label class="label" for="max_nonbulk">Maximum bill allowed for non-bulk orders (LKR)</label>
                        <input class="form-control" type="number" min="0" name="max_nonbulk" id="max_nonbulk" required
                               value="<?= $details->max_nonbulk ?>">
                    </div>
                    <button class="btn btn-success text-uppercase fw-bold" type="submit" id="general-submit-button">
                        Save Details
                    </button>
                </form>
            </div>
        </div>

        <div id="parent-contact" class="p-4">
            <h3 class="d-inline">Contact Details</h3> <i class="fas mr-2 pointer fa-chevron-down"></i><br>
            <div id="contact" class="w-75 p-4">
                <form action="<?= ROOT ?>/admin/settings/update" method="POST" class="form">
                    <div class="form-group">
                        <label class="label" for="email">Email</label>
                        <input class="form-control" type="text" name="email" id="email" required
                               value="<?= $details->email ?>">
                    </div>
                    <div class="form-group">
                        <label class="label" for="contact_no">Contact No</label>
                        <input class="form-control" type="text" name="contact_no" id="contact_no" required
                               value="<?= $details->contact_no ?>">
                    </div>
                    <div class="form-group">
                        <label class="label" for="twitter_url">Twitter Link</label>
                        <input class="form-control" type="text" name="twitter_url" id="twitter_url" required
                               value="<?= $details->twitter_url ?>">
                    </div>
                    <div class="form-group">
                        <label class="label" for="instagram_url">Instagram Link</label>
                        <input class="form-control" type="text" name="instagram_url" id="instagram_url" required
                               value="<?= $details->instagram_url ?>">
                    </div>


                    <button class="btn btn-success text-uppercase fw-bold" type="submit" id="contact-submit-button">
                        Save Details
                    </button>
                </form>
            </div>
        </div>

        <!--        <div id="parent-appearance" class="p-4">-->
        <!--            <h3 class="d-inline">Appearance</h3> <i class="fas mr-2 pointer fa-chevron-down"></i>-->
        <!--            <div id="appearance" class="w-75 p-4">-->
        <!--                <form action="-->
        <?php //= ROOT ?><!--/admin/settings/updateAppearance" method="POST" class="form" enctype="multipart/form-data">-->
        <!--                    <div class="form-group">-->
        <!--                        <label class="label" for="logo_url">Restaurant Logo</label>-->
        <!--                        <input class="form-control" type="file" name="logo_url" id="logo_url">-->
        <!--                    </div>-->
        <!--                    <div class="form-group">-->
        <!--                        <label class="label" for="favicon_url">Favicon</label>-->
        <!--                        <input class="form-control" type="file" name="favicon_url" id="favicon_url">-->
        <!--                    </div>-->
        <!--                    <div class="form-group">-->
        <!--                        <label class="label" for="background_image_url">Background Image</label>-->
        <!--                        <input class="form-control" type="file" name="background_image_url" id="background_image_url">-->
        <!--                    </div>-->
        <!---->
        <!--                    <button class="btn btn-success text-uppercase fw-bold" type="submit" id="appearance-submit-button">-->
        <!--                        Save Details-->
        <!--                </form>-->
        <!--            </div>-->
        <!--        </div>-->

        <?php if (isset($error)): ?>
            <script>
                new Toast("fa-solid fa-exclamation-triangle", "#dc3545", "Error", "<?=$error?>", false, 3000);
            </script>
        <?php elseif (isset($success)): ?>
            <script>
                new Toast("fa-solid fa-check", "#28a745", "Success", "<?=$success?>", false, 3000);
            </script>
        <?php endif; ?>

    </div>
</body>

</html>
<script>

    ['general', 'appearance', 'contact'].forEach(function (id) {
        let ele = document.getElementById(id);
        if (ele)
            ele.style.display = 'none';
    });

    let generalchevron = document.querySelector('#parent-general i');
    let generaldiv = document.getElementById('general');

    generalchevron.addEventListener('click', function () {
        if (generaldiv.style.display === 'none') {
            generalchevron.classList.remove('fa-chevron-down');
            generalchevron.classList.add('fa-chevron-up');
            generaldiv.style.display = 'block';
        } else {
            generalchevron.classList.remove('fa-chevron-up');
            generalchevron.classList.add('fa-chevron-down');
            generaldiv.style.display = 'none';
        }
    });

    // let appearancechevron = document.querySelector('#parent-appearance i');
    // let appearancediv = document.getElementById('appearance');
    //
    // appearancechevron.addEventListener('click', function () {
    //     if (appearancediv.style.display === 'none') {
    //         appearancechevron.classList.remove('fa-chevron-down');
    //         appearancechevron.classList.add('fa-chevron-up');
    //         appearancediv.style.display = 'block';
    //     } else {
    //         appearancechevron.classList.remove('fa-chevron-up');
    //         appearancechevron.classList.add('fa-chevron-down');
    //         appearancediv.style.display = 'none';
    //     }
    // });

    let contactchevron = document.querySelector('#parent-contact i');
    let contactdiv = document.getElementById('contact');

    contactchevron.addEventListener('click', function () {
        if (contactdiv.style.display === 'none') {
            contactchevron.classList.remove('fa-chevron-down');
            contactchevron.classList.add('fa-chevron-up');
            contactdiv.style.display = 'block';
        } else {
            contactchevron.classList.remove('fa-chevron-up');
            contactchevron.classList.add('fa-chevron-down');
            contactdiv.style.display = 'none';
        }
    });

    //if starting time is greater than ending time
    let opening_time = document.getElementById('opening_time');
    let closing_time = document.getElementById('closing_time');
    [opening_time, closing_time].forEach(function (element) {
        element.addEventListener('change', function () {
            if (opening_time.value > closing_time.value) {
                closing_time.value = opening_time.value;
                new Toast("fa-solid fa-exclamation-triangle", "#dc3545", "Error", "Opening time cannot be greater than closing time", false, 3000);
            }
        });
    });

    const contactSubmitButton = document.querySelector('#contact-submit-button');

    function validateEmail(email) {
        if (email == "") {
            return true;
        }
        let re = /\S+@\S+\.\S+/;
        return re.test(email);
    }

    //validate email
    const email = document.querySelector('input[name="email"]');
    email.addEventListener('change', () => {
        if (!validateEmail(email.value)) {
            contactSubmitButton.disabled = true;
            new Toast("fa-solid fa-exclamation-circle", "red", "Error", "Email is not valid", false, 3000);
        } else {
            contactSubmitButton.disabled = false;
        }
    });

    const contact_no = document.querySelector('input[name="contact_no"]');
    contact_no.addEventListener('change', () => {
        if (contact_no.value == "") {
            submitButton.disabled = true;
            new Toast("fa-solid fa-exclamation-circle", "red", "Error", "Contact no is required", false, 3000);
        } else if (contact_no.value.length != 10) {
            contactSubmitButton.disabled = true;
            new Toast("fa-solid fa-exclamation-circle", "red", "Error", "Contact no must be 10 digits", false, 3000);
        } else {
            contactSubmitButton.disabled = false;
        }
    });
</script>
