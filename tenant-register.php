<?php
include ("navbar.php");
?>

<!DOCTYPE html>
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
            background-color: #f0f0f0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        h3 {
            font-weight: bold;
            text-align: center;
        }

        hr {
            border: 1px solid #ccc;
        }

        form {
            width: 95%;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 10px;
            position: relative;
            /* Added */
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-control {
            width: calc(100% - 30px);
            /* Adjusted */
            padding: 3px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .toggle-password {
            position: absolute;
            /* Adjusted */
            top: 75%;
            right: 40px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #333;

        }

        select,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 5px;
        }

        #output_image {
            max-width: 50%;
            height: auto;
            margin-top: 5px;
        }

        .btn {
            display: inline-block;
            width: 100%;
            padding: 10px;
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

        #password-strength {
            color: red;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 15px;
        }

        #password-match {
            color: red;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 15px;

        }

        .form-group-text-right {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3 style="font-weight: bold; text-align: center;">Tenant Register</h3>
        <hr><br>
        <form method="POST" action="tenant-engine.php" enctype="multipart/form-data">
            <input type="hidden" id="location" name="location" value="">
            <div class="form-group">
                <label for="full_name">Full Name:</label>
                <input type="text" class="form-control" id="full_name" placeholder="Enter Full Name" name="full_name"
                    required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email" required>
            </div>
            <div class="form-group">

                <label for="password1">Password:</label>
                <input type="password" class="form-control" id="password1" placeholder="Enter Password" name="password"
                    oninput="checkPasswordStrength()" required>
                <i class="toggle-password fas fa-eye-slash" onclick="togglePasswordVisibility('password1')"></i>
                <div id="password-strength"></div>
            </div>
            <div class="form-group">
                <label for="password2">Confirm Password:</label>
                <input type="password" class="form-control" id="password2" placeholder="Enter Password Again"
                    name="password2" oninput="checkPasswordsMatch()" required>
                <i class="toggle-password fas fa-eye-slash" onclick="togglePasswordVisibility('password2')"></i>
                <div id="password-match"></div>
            </div>
            <div class="form-group">
                <label for="phone_no">Phone No.:</label>
                <input type="text" class="form-control" id="phone_no" placeholder="Enter Phone No." name="phone_no"
                    required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control" id="address" placeholder="Enter Address" name="address"
                    required>
            </div>
            <div class="form-group">
                <label for="id_type">Type of ID:</label>
                <select class="form-control" name="id_type" required>
                    <option>Citizenship</option>
                    <option>Driving Licence</option>
                </select>
            </div>
            <div class="form-group">
                <label for="card_photo">Upload your Selected Card:</label>
                <input type="file" class="form-control" placeholder="Upload id photo" name="id_photo" accept="image/*"
                    onchange="preview_image(event)" required>
            </div>
            <div class="form-group">
                <label>Your selected File:</label><br>
                <img src="" id="output_image" alt="Selected File" height="100px" required>
            </div>
            <hr>
            <button id="submit" name="tenant_register" class="btn btn-primary btn-block"
                onclick="return Validate()">Register</button><br>
            <div class="form-group text-right">
                <label class="">Register as a <a href="owner-register.php">Owner</a>?</label><br>
            </div><br><br>
        </form>
    </div>

    <!-- Font Awesome CDN link -->
    <script href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

    <script type='text/javascript'>
        // Function to get the geolocation
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        // Function to handle the retrieved position
        function showPosition(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            document.getElementById("location").value = latitude + "," + longitude;
        }

        // Call getLocation() when the page loads
        window.onload = function () {
            getLocation();
        };
        function togglePasswordVisibility(fieldId) {
            var passwordField = document.getElementById(fieldId);
            var icon = passwordField.nextElementSibling;
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

        function preview_image(event) {
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById('output_image');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        function checkPasswordStrength() {
            var password = document.getElementById("password1").value;
            var strength = 0;

            // Check for uppercase letters
            if (/[A-Z]/.test(password)) {
                strength++;
            }

            // Check for lowercase letters
            if (/[a-z]/.test(password)) {
                strength++;
            }

            // Check for numbers
            if (/\d/.test(password)) {
                strength++;
            }

            // Check for special characters
            if (/[^A-Za-z0-9]/.test(password)) {
                strength++;
            }

            var strengthText = "";
            if (password.length < 8) {
                strengthText = "Password must be at least 8 characters long containing Uppercase, Lowercase, Special Characters.";
            } else {
                switch (strength) {
                    case 1:
                        strengthText = "Weak";
                        break;
                    case 2:
                        strengthText = "Moderate";
                        break;
                    case 3:
                        strengthText = "Strong";
                        break;
                    case 4:
                        strengthText = "Very Strong";
                        break;
                }
            }

            document.getElementById("password-strength").innerText = "" + strengthText;
        }

        function checkPasswordsMatch() {
            var password1 = document.getElementById("password1").value;
            var password2 = document.getElementById("password2").value;

            if (password1 !== password2) {
                document.getElementById("password-match").innerText = "Passwords do not match.";
            } else {
                document.getElementById("password-match").innerText = "";
            }
        }

        function Validate() {
            var password = document.getElementById("password1").value;
            var confirmPassword = document.getElementById("password2").value;
            if (password != confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }
            return true;
        }
    </script>
</body>

<br><br>
<?php
include ("footer.php");
?>

</html>