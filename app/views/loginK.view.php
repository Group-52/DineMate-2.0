<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Page</title>
</head>

<style>
    body{
        width: 100%;
        height: 100vh;
        background: linear-gradient(
        to right,
        #FFFFFF 0%, 
        #FFFFFF 65%,
        #FF4546 65%,
        #FF4546 100%
        );
    }

    form {
        border-radius: 0 50px 0 0; 
        border: 2px solid #f1f1f1;
        padding: 20px 20px 20px 20px;
        width: 60%;
        height: 100%;
    }

    #container {
        width: 70%;
        margin: 0px auto;
    }

    img{
        width: 100px;
        height: 100px;
        background: #FF4546;
    }

    input[type=text], input[type=password] {
        width: 70%;
        padding: 20px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    span.span1 {
        float: right;
        padding-top: 6px;
        padding-bottom: 6px;
        padding-right: 30%;
    }

    button {
        background-color:#FF4546;
        color: white;
        padding: 20px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 70%;
    }
</style>

<body>
  <form action = "" method="post" class="split left">
    <img src="../assets/images/login/logo.png" alt="Logo">
    <h1>Login with DineMate</h1>

    <div class="container">
      <label for="username"><b>Email</b></label><br>
      <input type="text" placeholder="Email" name="username" required></div><br>
      
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