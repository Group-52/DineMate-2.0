<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/users.css">
    <title>Users</title>
</head>

<body class="dashboard">
    <?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
    <div class="dashboard-container">
        <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
        <div class="w-100 h-100 p-5">
            <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
                <div>
                    <h1 class="display-5 mb-2 d-inline-block">Users</h1>
                    <div id="search" class="form-search order-md-0 order-1 ml-5 w-50 d-inline-block">
                        <input type="text" class="form-control" placeholder="Search Customers" id="search-field">
                        <button class="form-search-icon">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                    <div class="my-4 d-flex flex-row">
                        <div class="tablinks display-6 fw-bold mr-4 pointer" onclick="openTab(event, 'register')">Registered Users</div>
                        <div class="tablinks display-6 fw-bold mr-4 pointer" onclick="openTab(event, 'guest')">Guests</div>
                        <div class="tablinks display-6 fw-bold pointer" onclick="openTab(event, 'blocklist')">Blacklisted Users</div>
                    </div>
                </div>
            </div>
            <div id="user-tables">

                <div id="register" class="tabcontent">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">User ID</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Contact No</th>
                            <th scope="col">Email</th>
                        </tr>
                        </thead>
                        <tbody class="text-center">
                        <?php if (isset($reg)) : ?>
                            <?php foreach ($reg as $r1) : ?>
                                <tr>
                                    <td><?= $r1->user_id ?></td>
                                    <td><?= $r1->first_name ?></td>
                                    <td><?= $r1->last_name ?></td>
                                    <td><?= $r1->contact_no ?></td>
                                    <td><?= $r1->email ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">No registered users</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>


                <div id="guest" class="tabcontent">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Guest ID</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Contact No</th>
                                <th scope="col">Email</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php if (isset($guest)) : ?>
                                <?php foreach ($guest as $g1) : ?>
                                    <tr>
                                        <td><?= $g1->guest_id ?></td>
                                        <td><?= $g1->first_name ?></td>
                                        <td><?= $g1->last_name ?></td>
                                        <td><?= $g1->contact_no ?></td>
                                        <td><?= $g1->email ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5">No guests</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div id="blocklist" class="tabcontent">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">User ID</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Contact No</th>
                                <th scope="col">Email</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php if (isset($block)) : ?>
                                <?php foreach ($block as $b1) : ?>
                                    <tr>
                                        <td><?= $b1->user_id ?></td>
                                        <td><?= $b1->first_name ?></td>
                                        <td><?= $b1->last_name ?></td>
                                        <td><?= $b1->contact_no ?></td>
                                        <td><?= $b1->email ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5">No blacklisted users</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>            
        </div>
    </div>
</body>

</html>

<script>

    //when clicked on row send to user page
    document.querySelectorAll('tbody tr').forEach(e => {
        e.addEventListener('click', () => {
            //if they aren't guests
            if (e.closest('.tabcontent').id != 'guest')
                window.location.href = `<?= ROOT ?>/admin/users/profile/${e.children[0].innerHTML}`
        })
    })

    function openTab(evt, divName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" secondary", "");
        }
        document.getElementById(divName).style.display = "block";
        evt.currentTarget.className += " secondary";
    }
    //click tab
    document.querySelector('.tablinks').click();

    //search
    document.querySelector('#search-field').addEventListener('keyup', () => {
        let search = document.querySelector('#search-field').value.toLowerCase();
        let rows = document.querySelectorAll('tbody tr');
        rows.forEach(e => {
            if (e.children[1].innerHTML.toLowerCase().includes(search) || e.children[2].innerHTML.toLowerCase().includes(search) || e.children[3].innerHTML.toLowerCase().includes(search) || e.children[4].innerHTML.toLowerCase().includes(search))
                e.style.display = 'table-row';
            else
                e.style.display = 'none';
        })
    })
</script>