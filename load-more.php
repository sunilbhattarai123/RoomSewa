<?php

// session_start();
include("navbar.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- <title>Your Property Page</title> -->
  <style>
    h1 {
      text-align: center;
      color: #333;
      margin-top: 20px;
    }

    .container {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-around;
      padding: 20px;
      border-radius: 100px;
    }

    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      border-radius: 40px;
      background-color: lightgray;
    }


    .col-sm-2 {
      width: 25%;

      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      /* margin: 30px; */
      padding: 20px;
      background-color: whitesmoke;
    }

    .card {
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.4);
      width: 400px;
      height: 350px;
      margin: 35px;
      text-align: center;
      transition: box-shadow 0.3s ease, transform 0.3s ease;
      border-radius: 20px;
      border-width: 10px;
      border-color: green;
    }

    .card:hover {
      box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
      opacity: 0.8;
      transform: scale(1.1);
    }

    .btn {
      display: block;
      width: 100%;
      padding: 10px;
      background-color: green;
      color: white;
      text-decoration: none;
      border-radius: 20px;
      transition: background-color 0.3s ease;
    }

    .btn:hover {
      background-color: chocolate;
      color: blueviolet;
    }

    .image {
      min-width: 100%;
      min-height: 200px;
      max-width: 100%;
      max-height: 200px;
      object-fit: cover;
    }.label {
      display: inline;
      padding: 15px;
      border-radius: 5px;
      font-weight: bold;
      font-size: 1.5rem;
    }

    .available {
      background-color: green;
      color: white;
    }

    .booked {
      background-color: red;
      color: white;
    }
  </style>
</head>

<body>

  <h1>Featured Properties</h1>

  <div class="container">
    <?php
    include("config/config.php");

    $sql = "SELECT * FROM add_property ORDER BY RAND() LIMIT 8";
    $query = mysqli_query($db, $sql);

    if (mysqli_num_rows($query) > 0) {
      while ($rows = mysqli_fetch_assoc($query)) {
        $property_id = $rows["property_id"];
        $bookedFlag= $rows['booked'];
        ?>
        <div class="col-sm-2">
          <div class="card">
            <?php
            $sql2 = "SELECT * FROM property_photo where property_id='$property_id'";
            $query2 = mysqli_query($db, $sql2);

            if (mysqli_num_rows($query2) > 0) {
              $row = mysqli_fetch_assoc($query2);
              $photo = $row['p_photo'];
              echo '<img class="image" src="owner/' . $photo . '">';
            }
            
            ?>
            <div class="label">
              <?php if ($bookedFlag == 'No') { ?>
                <span class="label available">Available</span>
              <?php } elseif ($bookedFlag == 'Yes') { ?>
                <span class="label booked" > Booked</span>
              <?php } ?>
            </div>
            <br>
            <br>
            <h4><b>
                <?php echo $rows['property_type']; ?>
              </b></h4>
            <p>
              <?php echo $rows['city'] . ', ' . $rows['district'] ?>
            </p>
            <br>
            <p>
              <?php echo '<a href="view-property-login.php?property_id=' . $rows['property_id'] . '" class="btn btn-primary">View Property</a><br>'; ?>
            </p>
            
          </div>
        </div>
        <?php
      }
    }
    ?>

  </div>
  <?php
  include("footer.php");

  ?>

</body>

</html>