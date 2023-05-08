<!DOCTYPE html>
<html lang="en">
<head>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/admin/menus.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/tables.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <script src="<?= ROOT ?>/assets/js/admin/common.js"></script>
</head>
<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
        <?php if (isset($m)): ?>
            <form method="POST">
                <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
<!--                    chevron right-->
                    <h1 class="display-5 mb-2"><a class="link" href="<?= ROOT ?>/admin/menus">Menus</a><i class="fa-solid fa-chevron-right mx-2"></i>Edit</h1>
                    <button class="btn btn-success text-uppercase fw-bold" type="submit" href="<?= ROOT ?>/admin/menus">
                        Update Menu
                    </button>
                </div>
                <div class="w-50">
                    <div class="form-group">
                        <label class="label" for="menu_id">Menu ID</label>
                        <input class="form-control" type="text" name="menu_id" value="<?= $m->menu_id ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label class="label" for="name">Name</label>
                        <input class="form-control" type="text" name="menu_name" value="<?= $m->menu_name ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="label" for="description">Description</label>
                        <input class="form-control" type="text" name="description" value="<?= $m->description ?>"
                               required>
                    </div>
                    <div class="form-group" id="start-time-div">
                        <label class="label" for="start_time">From Time</label>
                        <input class="form-control" type="time" name="start_time" id="start_time" value="<?= $m->start_time ?>">
                    </div>
                    <div class="form-group" id="end-time-div">
                        <label class="label" for="end_time">To Time</label>
                        <input class="form-control" type="time" name="end_time" id="end_time" value="<?= $m->end_time ?>">
                    </div>
                    <div class="form-group">
                        <label class="label d-inline" for="all_day">All Day</label>
                        <input class="form-control d-inline w-25" type="checkbox"
                               name="all_day" <?= $m->all_day ? 'checked' : '' ?>>
                    </div>
                </div>
            </form>
        <?php else: ?>
            <h1>Menu not found</h1>
        <?php endif; ?>
    </div>
</div>
</body>

</html>

<script>
    const submit = document.querySelector('button[type="submit"]');

    //add event listener to all day checkbox
    const allDay = document.querySelector('input[name="all_day"]');
    allDay.addEventListener('change', () => {
        let inputstart = document.querySelector('input[name="start_time"]');
        let inputend = document.querySelector('input[name="end_time"]');
        if (allDay.checked) {
            inputstart.setAttribute('required', false);
            inputend.setAttribute('required', false);
            //disable start and end time
            inputstart.disabled = true;
            inputend.disabled = true;
            //clear the values
            inputstart.value = '';
            inputend.value = '';
        } else {
            inputstart.setAttribute('required', true);
            inputend.setAttribute('required', true);
            //enable start and end time
            inputstart.disabled = false;
            inputend.disabled = false;

        }
    });

    function validateTime() {
        const startTime = document.querySelector('#start_time').value;
        const endTime = document.querySelector('#end_time').value;
        // Ensure start time is before end time
        if (startTime >= endTime) {
            new Toast("fa-solid fa-exclamation-circle", "red", "Error", "Start time must be less than end time", false, 3000);
            submit.disabled = true;
        } else {
            submit.disabled = false;
        }
    }

    document.querySelector('#start_time').addEventListener('change', validateTime);
    document.querySelector('#end_time').addEventListener('change', validateTime);
</script>
