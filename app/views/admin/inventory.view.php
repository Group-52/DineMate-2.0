<!DOCTYPE html>
<html lang="en">

<head>
  <?php include VIEWS . "/partials/admin/head.partial.php" ?>
  <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
  <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/inventory.css">
</head>

<body class="dashboard">
  <?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
  <div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
      <div class="dashboard-header">

        <h1 class="display-3 active">Inventory</h1>
      </div>

      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Amount Remaining</th>
            <th>Last Updated</th>
            <th> Max Stock Level</th>
            <th> Buffer Stock Level</th>
            <th>Reorder Level</th>
            <th> Lead Time</th>

          </tr>
        </thead>
        <tbody>
          <?php if (isset($inventory)) : ?>
            <?php foreach ($inventory as $item) : ?>
              <tr data-item-id="<?= $item->item_id ?>">
                <td data-field-name="item_name"><?= $item->item_name ?></td>
                <td data-field-name="amount_remaining"><?= $item->amount_remaining ?></td>
                <td data-field-name="last_updated"><?= $item->last_updated ?></td>
                <td data-field-name="max_stock_level"><?= $item->max_stock_level ?></td>
                <td data-field-name="buffer_stock_level"><?= $item->buffer_stock_level ?></td>
                <td data-field-name="reorder_level"><?= $item->reorder_level ?></td>
                <td data-field-name="lead_time"><?= $item->lead_time ?></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
      <a href="#" onclick="makeEditable()" id="editButton" class='btn btn-primary'>Edit</a>
      <a href="#" onclick="updateInventory()" class='btn btn-primary' id="updateButton">Update</a>
      <a href="<?= ROOT ?>/admin/inventory/info" class='btn btn-primary' id="switch-button">Detailed View</a>
    </div>
  </div>
</body>

</html>

<script>
  function makeEditable() {
    var cells = document.querySelectorAll("td[data-field-name='max_stock_level'], td[data-field-name='buffer_stock_level'], td[data-field-name='reorder_level'], td[data-field-name='lead_time']");
    for (var i = 0; i < cells.length; i++) {
      cells[i].setAttribute("contenteditable", "true");
      cells[i].classList.add("editable");
      cells[i].addEventListener("input", function() {
        this.setAttribute("data-changed", true);
      })
    }
    // make upadate button visible
    document.getElementById("updateButton").style.display = "inline-block";

    // focus on first editable cell
    cells[0].focus();
  }

  function makeUneditable() {
    var cells = document.querySelectorAll("td[data-field-name='max_stock_level'], td[data-field-name='buffer_stock_level'], td[data-field-name='reorder_level'], td[data-field-name='lead_time']");
    for (var i = 0; i < cells.length; i++) {
      cells[i].setAttribute("contenteditable", "false");
      cells[i].classList.remove("editable");
    }

    // hide update button
    document.getElementById("updateButton").style.display = "none";
    // make editable button visible
    document.getElementById("editButton").style.display = "inline-block";
  }

  function updateInventory() {
    // Collect data from editable cells
    var cells = document.querySelectorAll(".editable");
    var data = [];
    for (var i = 0; i < cells.length; i++) {
      var row = cells[i].parentNode;
      var itemid = row.getAttribute("data-item-id");
      var fieldName = cells[i].getAttribute("data-field-name");
      var newValue = cells[i].innerHTML;
      if (cells[i].hasAttribute('data-changed')) {
        data.push({
          itemid: itemid,
          fieldName: fieldName,
          newValue: newValue
        });
      }
    }

    makeUneditable();


    // Send data to server

    let fetchRes = fetch(
      "<?= ROOT ?>/admin/inventory/updateMain", {
        method: "POST",
        credentials: 'same-origin',
        mode: 'same-origin',
        headers: {
          'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(data)
      });

    fetchRes.then(res => res.json())
      .catch(err => {
        console.log(err)
      })

  }
</script>