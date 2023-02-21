<!DOCTYPE html>
<html lang="en">

<head>
  <?php include VIEWS . "/partials/admin/head.partial.php" ?>
  <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
  <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/inventory.css">
  <script src="<?= ASSETS ?>/js/admin/inventory2.js"></script>
</head>

<body class="dashboard">
  <?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
  <div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
      <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
        <h1 class="display-3">Batches</h1>
        <a class="btn btn-primary text-uppercase fw-bold" href="#" id="finish-button">Finish Editing</a>
        <a class="btn btn-primary text-uppercase fw-bold" href="#" id="edit-button">Edit</a>
        <a class="btn btn-primary text-uppercase fw-bold" href="<?= ROOT ?>/admin/inventory" id="switch-button">Back</a>
      </div>
      <table class="table">
        <thead>
          <tr>
            <th>Purchase ID</th>
            <th>Name</th>
            <th>Amount Remaining</th>
            <th> Expiry Risk</th>
            <th> Special Notes</th>
            <th>Expiry Date</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php if (isset($inventory2)) : ?>
            <?php foreach ($inventory2 as $item) : ?>
              <tr data-item-id="<?= $item->item_id ?>" data-purchase-id="<?= $item->pid ?>">
                <td ><?= $item->pid ?></td>
                <td ><?= $item->item_name ?></td>
                <td data-field-name="amount_remaining" data-unit="<?=$item->abbreviation?>"><?= $item->amount_remaining ?> <?=$item->abbreviation?></td>
                <td data-field-name="expiry_risk"><?= $item->expiry_risk ? "Yes" : "No" ?></td>
                <td data-field-name="special_notes"><?= $item->special_notes ?></td>
                <td ><?= $item->expiry_date ?></td>
                <td><i class="fa fa-pencil-square-o edit-icon" aria-hidden="true"></i></td>
                <td><i class="fa fa-trash trash-icon" aria-hidden="true"></i></td>
                <td><i class="fa fa-check-circle tick-icon edit-options" aria-hidden="true"></i></td>
                <td><i class="fa fa-times-circle cross-icon edit-options" aria-hidden="true"></i></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>

    </div>
  </div>
</body>

</html>
