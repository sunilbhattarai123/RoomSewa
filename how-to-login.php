<?php 

include("navbar.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f5f5f5;
        }

        .sign-in-form-section {
            padding: 50px 0;
        }

        .container {
            width: 70%;
            margin: 0 auto;
        }

        .sign-up {
            text-align: center;
        }

        h3 {
            font-weight: bold;
        }

        hr {
            border: 1px solid #ccc;
        }

        p {
            margin-bottom: 30px;
        }

        .btn {
            display: inline-block;
            width: 200px;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            color: #fff;
            background-color: #17a2b8;
            border: 1px solid #17a2b8;
            border-radius: 5px;
            margin-right: 10px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn:hover {
            background-color: #138496;
            border-color: #138496;
        }
    </style>
</head>
<body>
    <section class="container-fluid sign-in-form-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 sign-up">
                    <h3 style="font-weight: bold;">How do you want to Login?</h3><hr>
                    <p>If you want to sign in as a tenant click on tenant login button otherwise click on owner login button.</p><br><br>
                    <button type="submit" class="btn btn-info"  onclick="window.location.href='tenant-login.php'">Tenant Login</button>
                    <button type="submit" class="btn btn-info"  onclick="window.location.href='owner-login.php'">Owner Login</button>
                    <button type="submit" class="btn btn-info"  onclick="window.location.href='admin-login.php'">Admin Login</button>
                </div>
            </div>
        </div>
    </section>
    
</body>
<?php
  include("footer.php");
  ?>
</html>
