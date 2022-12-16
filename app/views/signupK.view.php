<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Signup Page</title>
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
            border: 2px solid #f1f1f1;
            padding: 20px 20px 20px 20px;
            width: 60%;
            height: 100%;
        }

        #container {
            width: 70%;
            margin: 0px auto;
        }

        input{
            padding:15px;
            margin:10px;
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
    <div class = "container">
        <form action="" method="POST" class="split left">
          
          <img src="../assets/images/login/logo.png" alt="Logo">
          
          <h1>Register with DineMate</h1>

          <span id="error-display" class="error-display"> </span> <br>

          <label for ="first_name"><b>First Name</b></label><br>
          <input name = "first_name" type ="text" placeholder = "First Name" required><br>

          <label for="last_name"><b>Last Name</b></label><br>
          <input name = "last_name" type ="text" placeholder = "Last Name" required><br>

          <label for="username"><b>User Name</b></label><br>
          <input name = "username" type ="text" placeholder = "User Name" required><br>

          <label for ="contactNo"><b>Contact No</b></label><br>
          <input name = "contact_no" type="text" placeholder = "Contact No" required><br>

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