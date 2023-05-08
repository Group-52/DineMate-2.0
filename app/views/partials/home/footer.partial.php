<?php if (isset($footer_details)) : ?>
<div class="footer mt-5">
    <div class="container py-5">
        <div class="d-flex align-items-center flex-row">
            <div class="col-lg-3 col-6 p-3">
                <img src="<?= ASSETS ?>/images/logos/logo_Full Logo.svg" alt="logo" class="img-fluid">
            </div>
            <div class="col-offset-lg-6"></div>
            <div class="col-lg-3 col-6 p-2 text-right">
                <h1 class="display-5">Contact Us</h1>

                <a class="link single-line" href="mailto:<?= $footer_details->email ?>"><i class="fa-solid fa-envelope"></i>
                    &nbsp;&nbsp;<?= $footer_details->email ?></a><br>

                <a class="link single-line" href="tel:<?= $footer_details->contact_no ?>"><i class="fa-solid fa-phone"></i>
                    &nbsp;&nbsp;<?= $footer_details->contact_no ?></a><br>


                <div><?= substr($footer_details->opening_time, 0, 5) ?> - <?= substr($footer_details->closing_time, 0, 5) ?></div>

                <div class="mt-3">
                    &copy; 2023 DineMate
                </div>
            </div>
        </div>
        <div class="text-center fs-3">
            <a href="<?= $footer_details->twitter_url ?>" class="link mr-2"><i class="fa-brands fa-twitter"></i></a>
            <a href="<?= $footer_details->instagram_url ?>" class="link"><i class="fa-brands fa-instagram"></i></a>
        </div>
    </div>
</div>
<?php endif; ?>
<div class="promotion-bar text-center d-none pointer">
    <div class="d-flex flex-lg-row flex-column align-items-center justify-content-center p-3">
        <div class="promotion-title mx-1 text-uppercase fw-bold"></div>
        <div class="promotion-price mx-1 secondary"></div>
    </div>
    <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0"
         aria-valuemax="100"></div>
</div>