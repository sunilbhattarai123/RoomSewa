<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
// session_start();
if (isset($_SESSION['email'])) {
  global $uemail;
  $uemail = $_SESSION['email'];
  // echo $uemail;
}
include 'config/config.php';}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Property Listing</title>
  <style>
    /* body {
      font-family: Arial, sans-serif;
     
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      background-color: lightgray;
    } */

    .container {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-around;
      padding: 20px;
      background-color: whitesmoke;
    }

    .card {
      position: relative;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.4);
      width: 300px;
      margin: 35px;
      text-align: center;
      overflow: hidden;
      transition: box-shadow 0.3s ease, transform 0.3s ease;
      border-radius: 10px;
      border-width: 10px;
      border-color: green;
    }

    .card:hover {
      box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
      opacity: 0.8;
      transform: scale(1.1);
    }

    .image {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }

    .property-info {
      padding: 16px;
    }

    .btn {
      display: block;
      width: 100%;
      padding: 10px;
      background-color: green;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    .btn:hover {
      background-color: chocolate;
      color: blueviolet;
    }

    /* Add this CSS to your existing styles */
    .label {
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

  <div class="container">
    <?php
    function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        // Radius of the Earth in kilometers
        $earthRadius = 6371.0; // Average radius, can be adjusted
    
        // Convert latitude and longitude from degrees to radians
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
    
        $lat1 = deg2rad($lat1);
        $lat2 = deg2rad($lat2);
    
        // Haversine formula
        $a = sin($dLat / 2) * sin($dLat / 2) +
            sin($dLon / 2) * sin($dLon / 2) * cos($lat1) * cos($lat2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    
        // Distance calculation
        $distance = $earthRadius * $c;
    
        return $distance;
    }
    
    $sqlTenant = "SELECT * FROM tenant WHERE email='$uemail'";
    $sqlResult = mysqli_query($db, $sqlTenant);

    if ($res = mysqli_num_rows($sqlResult) > 0) {
      $resl = mysqli_fetch_assoc($sqlResult);
      // $latitude = $resl['latitude'];
      // $longitude = $resl['longitude'];
      $latitude = "28.000";
      $longitude = "34.00";
      $address = $resl['address']; 
      
      $maxDistance = 10;
      $minDistance = 0;
    
      $sql = "SELECT *, 
            (6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude)))) AS distance 
            FROM add_property 
            WHERE CONCAT(province, ' ', zone, ' ', district, ' ', city, ' ', vdc_municipality, ' ', tole) LIKE '%$address%'
            HAVING distance between $minDistance and $maxDistance
            ORDER BY RAND() 
            LIMIT 21";
      $query = mysqli_query($db, $sql);

      if (mysqli_num_rows($query) > 0) {
        while ($rows = mysqli_fetch_assoc($query)) {
          $bookedFlag = $rows['booked'];
          $property_id = $rows['property_id'];
          $sql2 = "SELECT * FROM property_photo WHERE property_id='$property_id'";
          $query2 = mysqli_query($db, $sql2);

          if (mysqli_num_rows($query2) > 0) {
            $row = mysqli_fetch_assoc($query2);
            $photo = $row['p_photo'];
          }
    ?>

          <div class="card">
            <?php if (isset($photo)) { ?>
              <img class="image" src="owner/<?php echo $photo; ?>" alt="Property Image">
            <?php } ?>
            <div class="label">
              <?php if ($bookedFlag == 'No') { ?>
                <span class="label available">Available</span>
              <?php } elseif ($bookedFlag == 'Yes') { ?>
                <span class="label booked">Booked</span>
              <?php } ?>
            </div>
            <div class="property-info">
              <h4><b><?php echo $rows['property_type']; ?></b></h4>
              <p><?php echo $rows['city'] . ', ' . $rows['district']; ?></p>
              <a href="view-property-login.php?property_id=<?php echo $rows['property_id']; ?>" class="btn">View Property</a>
            </div>
          </div>

    <?php
        }
      }
    }
    ?>
  </div>

</body>

</html>