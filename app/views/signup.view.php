<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Signin Template · Bootstrap v5.1</title>



    <style>
      input{
        padding:15px;
        margin:10px;
      }

    </style>

  </head>
  <body class="text-center">

  <form method="post">

    <?php if(!empty($errors)):?>
      <div class="alert alert-danger">
        <?= implode("<br>", $errors)?>
      </div>
    <?php endif;?>
  
    <h1>Create account</h1>

    <input name = "first_name" type ="text" placeholder = "First Name">
    <input name = "last_name" type ="text" placeholder = "Last Name">
    <input type = "text" name= "contactNo" placeholder="Contact No">
    <input name = "email" type= "text" placeholder="Email" >
    <input name = "password" type ="password" placeholder = "Password">
    <input name = "password_confirm" type ="password" placeholder = "Confirm Password">

    <button type="submit">Create</button>
    <a href="<?=ROOT?>">Home</a>
    <a href="<?=ROOT?>/auth/login">Login</a>

  </form>
  </body>
</html>
