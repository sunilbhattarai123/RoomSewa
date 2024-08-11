<?php


include("navbar.php");

?>
<!DOCTYPE html>
<html lang="en">

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        /* Your existing CSS styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: white;
        }

        .container {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
           
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            border-radius: 20px;
            background-color: #f0f0f0;
            margin-bottom: 20px;
        }

        h3 {
            font-weight: bold;
            text-align: center;
        }

        hr {
            border: 1px solid #ccc;
        }

        form {
            width: 70%;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .input-group {
            width: 100%;
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn {
            display: inline-block;
            width: auto;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            color: #fff;
            background-color: #007bff;
            border: 1px solid #007bff;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            color: #0056b3;
        }

        /* Additional styles for password toggle */
        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #333;
        }
    </style>
</head>
<body>
  

<div class="container">
  <h3 style="font-weight: bold; text-align: center;">Owner Login</h3>
  <hr><br><br>
  <form method="POST">
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
    </div>
    <div class="form-group">
                <label for="pwd">Password:</label>
                <div class="password-container"> <!-- Added container -->
                    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password" required>
                    <i class="toggle-password fas fa-eye-slash" onclick="togglePasswordVisibility()"></i> <!-- Eye icon -->
                </div>
    </div>
    <div class="form-group">
      <a href="forgot-password-owner.php">Forget your Password ? </a>
    </div>
    <input type="submit" id="submit" name="owner_login" class="btn btn-primary btn-block" value="Login">
    
  </form>
</div>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- JavaScript to toggle password visibility -->
<!-- JavaScript to toggle password visibility -->
<script>
        function togglePasswordVisibility() {
            var passwordField = document.getElementById("pwd");
            var icon = document.querySelector(".toggle-password");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                passwordField.type = "password";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        }
    </script>

   

<br><br>
<?php
  include("footer.php");
  ?>
</body>
</html>