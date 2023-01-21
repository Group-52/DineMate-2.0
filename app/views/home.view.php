<!DOCTYPE html>
<html lang="en">
<?php include VIEWS . "/partials/home/head.partial.php" ?>
<body>
<?php include VIEWS . "/partials/home/navbar.partial.php"; ?>

<?php if (isset($item)) $item->render() ?>
<div class="welcome mb-3"
     style="background: linear-gradient(to right, rgba(255, 255, 255, 0.9) 30%, rgba(255, 255, 255, 0) 98.75%),
             url('<?= ASSETS ?>/images/home/banner.jpg') no-repeat center center;
             background-size: cover;"
>
    <h1 class="display-3">Good
        <?php
        $hour = date('G');
        if ($hour >= 5 && $hour < 12) {
            echo "Morning";
        } elseif ($hour >= 12 && $hour < 17) {
            echo "Afternoon";
        } else {
            echo "Evening";
        }
        ?>, <?= $user->first_name ?? "User" ?></h1>
</div>
<div class="container">
    <?php if (isset($menus)) foreach ($menus as $menu) $menu->render() ?>
</div>

</body>
</html>