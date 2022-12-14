<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">

    <title>Signup Page</title>
    <style>
      input{
        padding:15px;
        margin:10px;
      }
      img{
        width: 100px;
        height: 100px;
        background: #FF4546;
    }

    </style>
  </head>
  
  <body>
    <div class = "container">
        <form action="" method="post" class="split left">
          
          <!-- <img src="../assets/images/manager/logo.png" alt="Logo"> -->
          
          <h1>Register with DineMate</h1>

          <span id="error-display" class="error-display"> </span> <br>

          <label for ="fname"><b>First Name</b></label><br>
          <input name = "fname" type ="text" placeholder = "First Name" required><br>

          <label for="lname"><b>Last Name</b></label><br>
          <input name = "lname" type ="text" placeholder = "Last Name" required><br>

          <label for ="contactNo"><b>Contact No</b></label><br>
          <input name = "contactNo" type="text" placeholder = "Contact No" required><br>

          <label for="email"><b>Email</b></label><br>
          <input name = "email" type = "text" placeholder = "Email" required><br>

          <label for="password"><b>Password</b></label><br>
          <input name = "password" type ="password" placeholder = "Password" required ><br>

          <label for="password_confirmation"><b>Confirm Password</b></label><br>
          <input name = "password_confirmation" type ="password" placeholder = "Confirm Password" required><br>

          <button type = "submit" name = "register">Register</button><br>
          
          <div class="container">
            <span class="span1">Alredy a user? Login <a href="<?=ROOT?>/loginK/login">here</a></span>
          </div>
        </form>
    </div>
  </body>
</html>