<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Signin Template · Bootstrap v5.1</title>
  <style>
    input {
      padding: 15px;
      margin: 10px;
    }
  </style>
</head>

<body>


  <form method="post">

    <?php if (!empty($errors)) : ?>
        <?= is_array($errors) ? implode("<br>", $errors) : $errors?>
    <?php endif; ?>

    <h1>Please sign in</h1>

    <input name = "email" type= "text" placeholder="Email" >
    <input name = "password" type ="password" placeholder = "Password">
    

    <button type="submit">Sign in</button>
    <a href="<?= ROOT ?>">Home</a>
    <a href="<?= ROOT ?>/auth/signup">Signup</a>

  </form>



</body>

</html>