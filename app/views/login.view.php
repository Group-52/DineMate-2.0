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

<body>

  <form method="post">

    <?php if (!empty($errors)) : ?>
      <?= is_array($errors) ? implode("<br>", $errors) : $errors ?>
    <?php endif; ?>

    <h1>Please sign in</h1>
    
      <div class="form__group field">
        <input name="email" type="text" placeholder="Email" class="form__field">
      </div>
      <div class="form__group field">
        <input name="password" type="password" placeholder="Password" class="form__field">
      </div>


      <button type="submit">Sign in</button>
      <a href="<?= ROOT ?>">Home</a>
      <a href="<?= ROOT ?>/auth/signup">Signup</a>
    </form>




</body>

</html>