<?php 
// ob_start(); // Start output buffering
session_start();
isset($_SESSION["email"]);
include("navbar.php");
include("config/config.php");

if(isset($_POST['send_message'])){
    
    $u_email=$_SESSION["email"];
    $owner_id=$_POST['owner_id'];
    $sql="SELECT * FROM tenant where (email='$u_email' and email_verified_at is not null)";
    $query=mysqli_query($db,$sql);

    if(mysqli_num_rows($query)>0)
    {
        while ($rows=mysqli_fetch_assoc($query)) {
            $tenant_id=$rows['tenant_id'];
   
            $sql1="SELECT * FROM chat where owner_id='$owner_id' AND tenant_id='$tenant_id' ";

            $query1 = mysqli_query($db,$sql1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Send Messages</title>
  <link rel="stylesheet" href="./owner/message-style.css">
  <style>
    /* Your styles go here */
  </style>
</head>
<body>
<div class="container">
  <center><h3>Send Messages</h3></center>
  <div class="display-chat">
    <?php
    if(mysqli_num_rows($query1)>0)
    {
      while($row= mysqli_fetch_assoc($query1)) 
      {
    ?>
        <div class="message">
          <p>
            <span><?php echo $row['message']; ?></span>
          </p>
        </div>
    <?php
      }
    }
    else
    {
    ?>
      <div class="message">
        <p>
          No previous chat available.
        </p>
      </div>
    <?php
    } 
    ?>
  </div>
  <form class="form-horizontal" method="POST" action="">
    <div class="form-group">
      <div class="col-sm-10"> 
        <input type="hidden" name="owner_id" value="<?php echo $owner_id; ?>">    
        <input type="hidden" name="tenant_id" value="<?php echo $tenant_id; ?>">      
        <textarea name="message" class="form-control" placeholder="Type your message here..."></textarea>
      </div>  
      <div class="col-sm-2">
        <input type="submit" name="send_message1" class="btn btn-primary" value="Send">
      </div>
    </div>
  </form>
</div>
</body>
</html>

<?php
        }
    }
}
?>
<?php

if(isset($_POST['send_message1'])){
  $u_email=$_SESSION["email"];
  $message=$_POST['message'];
  $owner_id=$_POST['owner_id'];
  $tenant_id=$_POST['tenant_id'];
  
  $sql="INSERT INTO chat(message,owner_id,tenant_id) VALUES ('$message','$owner_id','$tenant_id')";

  $query = mysqli_query($db,$sql);
  
  if($query)
  {
    header("Location: {$_SERVER['PHP_SELF']}");}
}
// ob_end_flush();
?>


<center><button onclick="goBack()" class="btn btn-success">Go Back</button></center>

<script>
function goBack() {
  event.preventDefault();
  window.history.back();
}
</script>

