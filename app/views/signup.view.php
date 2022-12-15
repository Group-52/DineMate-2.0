<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Signin Template · Bootstrap v5.1</title>



  <style>
    body {
      background: rgb(255, 72, 36);
      background: linear-gradient(90deg, rgba(255, 72, 36, 1) 7%, rgba(221, 179, 179, 1) 47%, rgba(255, 50, 10, 1) 87%);
    }
  </style>
  <link rel="stylesheet" href="<?= ASSETS ?>/css/dineth.css">
</head>

<body class="text-center">

  <form method="post">

    <?php if (!empty($errors)) : ?>
      <div class="alert alert-danger">
        <?= implode("<br>", $errors) ?>
      </div>
    <?php endif; ?>

    <h1>Create account</h1>

    <div class="form__group field">
      <input name="first_name" type="text" placeholder="First Name" class="form__field">
    </div>
    <div class="form__group field">
      <input name="last_name" type="text" placeholder="Last Name" class="form__field">
    </div>
    <div class="form__group field">
      <input type="text" name="contactNo" placeholder="Contact No" class="form__field">
    </div>
    <div class="form__group field">
      <input name="email" type="text" placeholder="Email" class="form__field">
    </div>
    <div class="form__group field">
      <input name="password" type="password" placeholder="Password" class="form__field">
    </div>
    <div class="form__group field">
      <input name="password_confirm" type="password" placeholder="Confirm Password" class="form__field">
    </div>


    <button type="submit">Create</button>
    <a href="<?= ROOT ?>">Home</a>
    <a href="<?= ROOT ?>/auth/login">Login</a>

  </form>
</body>

</html>