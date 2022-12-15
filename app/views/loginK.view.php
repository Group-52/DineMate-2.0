<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../assets/css/manager/style.css">

  <title>Login Page</title>
</head>

<body>
  <form action = "" method="post" class="split left">
    <img src="../assets/images/manager/logo.png" alt="Logo">
    <h1>Login with DineMate</h1>

    <div class="container">
      <label for="username"><b>Username</b></label><br>
      <input type="text" placeholder="Username" name="username" required></div><br>
      
      <label for="password"><b>Password</b></label><br>
      <input type="password" placeholder="Password" name="password" required><br>


      <div class="container">     
        <span class="span1">Forgot <a href="#">Username/Password?</a></span>
      </div><br>
      
      <button type="submit" name="login">Login</button><br>

      <div class="container">
        <span class="span1">Don't have an account? Sign up <a href="signup">here</a></span>
      </div>
      <a href="<?=ROOT?>/home">Home</a>
    </div>
  </form>
</body>

</html>