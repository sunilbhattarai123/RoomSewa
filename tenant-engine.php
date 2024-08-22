<?php
// session_start();
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php';
require './vendor/phpmailer/phpmailer/src/Exception.php';
require './vendor/phpmailer/phpmailer/src/SMTP.php';
require './vendor/phpmailer/phpmailer/src/PHPMailer.php';


$tenant_id = '';
$full_name = '';
$email = '';
$password = '';
$phone_no = '';
$address = '';
$id_type = '';
$id_photo = '';

$errors = array();

include './config/config.php';
include './config/bcrypt.php';

if (isset($_POST['tenant_register'])) {
  tenant_register();
}
if (isset($_POST['tenant_login'])) {
  tenant_login();
}
if (isset($_POST['tenant_update'])) {
  tenant_update();
}


function tenant_register()
{
  if (isset($_FILES['id_photo'])) {
    $id_photo = 'tenant-photo/'.microtime() . $_FILES['id_photo']['name'];

    // echo $_FILES['image']['name'].'<br>';

    if (!empty($_FILES['id_photo'])) {
      $path = "tenant-photo/";
      $path = $path . basename($_FILES['id_photo']['name']);
      if (move_uploaded_file($_FILES['id_photo']['tmp_name'], $path)) {
        echo "The file " . basename($_FILES['id_photo']['name']) . " has been uploaded";
      } else {
        echo "There was an error uploading the file, please try again!";
      }
    }
  }
  
// tenant-engine.php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];

    // Validate Full Name
    $full_name = trim($_POST['full_name']);
    if (empty($full_name)) {
        $errors['full_name'] = "Full Name is required.";
    } elseif (!preg_match("/^[a-zA-Z ]+$/", $full_name)) {
        $errors['full_name'] = "Full Name can only contain letters and spaces.";
    }

    // Validate Email
    $email = trim($_POST['email']);
    if (empty($email)) {
        $errors['email'] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }

    // Validate Password
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    if (empty($password)) {
        $errors['password'] = "Password is required.";
    } elseif (strlen($password) < 8) {
        $errors['password'] = "Password must be at least 8 characters long.";
    } elseif ($password !== $password2) {
        $errors['password2'] = "Passwords do not match.";
    }

    // Validate Phone Number
    $phone_no = trim($_POST['phone_no']);
    if (empty($phone_no)) {
        $errors['phone_no'] = "Phone number is required.";
    } elseif (!preg_match("/^\+977-?[0-9]{10}$/", $phone_no)) {
        $errors['phone_no'] = "Invalid phone number format. Use +977-XXXXXXXXXX.";
    }

    // Validate Address
    $address = trim($_POST['address']);
    if (empty($address)) {
        $errors['address'] = "Address is required.";
    } elseif (!preg_match("/^[a-zA-Z\s,.'-]+$/", $address)) {
        $errors['address'] = "Address can only contain letters, spaces, and special characters.";
    }

    // Validate ID Photo Upload
    if (isset($_FILES['id_photo']) && $_FILES['id_photo']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['id_photo']['tmp_name'];
        $fileName = $_FILES['id_photo']['name'];
        $fileSize = $_FILES['id_photo']['size'];
        $fileType = $_FILES['id_photo']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedfileExtensions = ['jpg', 'gif', 'png', 'jpeg'];
        if (!in_array($fileExtension, $allowedfileExtensions)) {
            $errors['id_photo'] = "Only JPG, JPEG, PNG, and GIF files are allowed.";
        }
    } else {
        $errors['id_photo'] = "ID photo upload is required.";
    }

    // If no errors, process the data
    if (empty($errors)) {
        // Save the tenant details in the database or perform other necessary actions

        // Redirect or give success message
        header("Location: success.php"); // Redirect to a success page
        exit();
    } else {
        // Handle the errors (display them back to the user)
        foreach ($errors as $error) {
            echo "<p style='color:red;'>{$error}</p>";
        }
    }
}


  global $tenant_id, $full_name, $email, $password, $phone_no, $address, $id_type, $id_photo, $errors, $db, $email_verified_at, $verification_code;
  //    $tenant_id = validate($_POST['tenant_id']);
  $full_name = validate($_POST['full_name']);
  $email = validate($_POST['email']);
  $password = validate($_POST['password']);
  $phone_no = validate($_POST['phone_no']);
  $address = validate($_POST['address']);
  $id_type = validate($_POST['id_type']);
  $id_photo = $path;
  $hashedPassword = hashPassword($password);
  $location = $_POST['location'];
  // Split the location string to get latitude and longitude
  echo $location . 'I am location';
  //    list($latitude, $longitude) = explode(",", $location);


  $mysql = "SELECT * FROM tenant WHERE email = '$email'";
  $res = mysqli_query($db, $mysql);
  // Fetch the result as an associative array
  // $row = $res->fetch_assoc();

  // Extract the count value
  $emailCount = mysqli_num_rows($res);
  if ($emailCount == 0) {

    //     //Instantiation and passing true enables exceptions
    $mail = new PHPMailer(true);
    try {
      //        //Enable verbose debug output
      $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;

      //Send using SMTP
      $mail->isSMTP();

      //Set the SMTP server to send through
      $mail->Host = 'smtp.gmail.com';

      //Enable SMTP authentication
      $mail->SMTPAuth = true;

      //SMTP username
      $mail->Username = 'sunilbhattarai131@gmail.com';

      //SMTP password
      $mail->Password = 'klxtbsqydwcoouor';

      //Enable TLS encryption;
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

      //TCP port to connect to, use 465 for PHPMailer::ENCRYPTION_SMTPS above
      $mail->Port = 587;

      //Recipients
      $mail->setFrom("sunilbhattarai131@gmail.com");

      //Add a recipient
      $mail->addAddress($email, $full_name);

      //Set email format to HTML
      $mail->isHTML(true);

      $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

      $mail->Subject = 'Email verification';
      $mail->Body = '<p>Your verification code is: <b style="font-size: 30px;">' . $verification_code . '</b></p>';



      $mail->send();

      //       // Existing code...
      // Insert into the tenant table
      $sql = "INSERT INTO tenant (full_name, email, password, phone_no, address, id_type, id_photo, verification_code, email_verified_at) VALUES ('$full_name', '$email', '$hashedPassword', '$phone_no', '$address', '$id_type', '$id_photo', '$verification_code', NULL)";
      mysqli_query($db, $sql);

      // Send headers after all the processing is done
      // header("Location: ./email-verification.php");
      header("Location: email-verification.php?email=" . $email);

      exit();

    } catch (Exception $e) {
      echo "Something went wrong";
    }
  } else {
    echo "Email " . $email . " already Exists.";
  }
}

function tenant_login()
{
  global $email, $db;
  $email = validate($_POST['email']);
  $password = validate($_POST['password']);

  // Hash the entered password using bcrypt
  $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

  $sql = "SELECT * FROM tenant where email='$email' LIMIT 1";
  $result = mysqli_query($db, $sql);
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    // Verify the entered password with the hashed password from the database

    if (password_verify($password, $row['password'])) {
      if ($row['email_verified_at'] == null) {
        die("Please verify your email <a href='email-verification.php?email=" . $email . "'>from here</a>");
      }
      $_SESSION['email'] = $email;
      echo '<script>window.location.href ="index.php";</script>';
    } else {
      // Incorrect password
      displayLoginError("Incorrect Password");
    }
  } else {
    // Email not found
    displayLoginError("Incorrect Email or not registered.");
  }
}

// Helper function to display login error message
function displayLoginError($message)
{
  echo <<<HTML
    <style>
        .alert {
            padding: 20px;
            background-color: #DC143C;
            color: white;
        }

        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .closebtn:hover {
            color: black;
        }
    </style>
    <div class="container">
        <div class="alert">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <strong>$message</strong> Click here to <a href="tenant-register.php" style="color: lightblue;"><b>Register</b></a>.
        </div>
    </div>
HTML;
}

function tenant_update()
{
    global $owner_id, $full_name, $email, $password, $phone_no, $address, $id_type, $id_photo, $errors, $db;
    $tenant_id = validate($_POST['tenant_id']);
    $full_name = validate($_POST['full_name']);
    $email = validate($_POST['email']);
    $phone_no = validate($_POST['phone_no']);
    $address = validate($_POST['address']);
    $id_type = validate($_POST['id_type']);
    $password = md5($password); // Encrypt password
    $sql = "UPDATE tenant SET full_name='$full_name',email='$email',phone_no='$phone_no',address='$address',id_type='$id_type' WHERE tenant_id='$tenant_id'";
    $query = mysqli_query($db, $sql);
    if (!empty($query)) {
        ?>

        <style>
            .alert {
                padding: 20px;
                background-color: #DC143C;
                color: white;
            }

            .closebtn {
                margin-left: 15px;
                color: white;
                font-weight: bold;
                float: right;
                font-size: 22px;
                line-height: 20px;
                cursor: pointer;
                transition: 0.3s;
            }

            .closebtn:hover {
                color: black;
            }
        </style>
        <script>
            window.setTimeout(function () {
                $(".alert").fadeTo(1000, 0).slideUp(500, function () {
                    $(this).remove();
                });
            }, 2000);
        </script>
        <div class="container">
            <div class="alert" role='alert'>
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                <center><strong>Your Information has been updated.</strong></center>
            </div>
        </div>


        <?php
    }
}


function validate($data)
{
  $data = trim($data);
  $data = stripcslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
