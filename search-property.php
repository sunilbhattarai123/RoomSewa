<?php 
session_start();
isset($_SESSION["email"]);
include("navbar.php");


 ?>

 <?php 
include("config/config.php");
 ?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>

.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 100%;
  min-width: 100%;
  margin: auto;
  text-align: center;
  font-family: arial;
  display: inline;
}

.card:hover {
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
  opacity: 0.8;
}

.container {
  padding: 2px 16px;
}

.btn {
  width: 100%;
}

.image {
  min-width: 100%;
  min-height: 200px;
  max-width: 100%;
  max-height:200px;
}
</style>
</head>
<body>
<?php 
global $db;

if (isset($_POST['submit'])) {
    $location = $_POST['search_property']; // Location entered by the user
    $property_type = $_POST['property_type']; // Property type selected by the user
    $price_range = $_POST['price_range']; // Price range selected by the user

    // Initial SQL query
    $sql = "SELECT * FROM add_property WHERE (zone LIKE '%$location%' 
            OR district LIKE '%$location%' 
            OR province LIKE '%$location%' 
            OR city LIKE '%$location%' 
            OR tole LIKE '%$location%' 
            OR country LIKE '%$location%')";

    // Filter by property type if selected
    if (!empty($property_type)) {
        $sql .= " AND property_type = '$property_type'";
    }

    // Filter by price range if selected
    if (!empty($price_range)) {
        if ($price_range == '0-5000') {
            $sql .= " AND estimated_price BETWEEN 0 AND 5000";
        } elseif ($price_range == '5000-10000') {
            $sql .= " AND estimated_price BETWEEN 5000 AND 10000";
        } elseif ($price_range == '10000-20000') {
            $sql .= " AND estimated_price BETWEEN 10000 AND 20000";
        } elseif ($price_range == '20000+') {
            $sql .= " AND estimated_price > 20000";
        }
    }


    $query = mysqli_query($db, $sql);

    echo '<center><h1>Searched Properties</h1></center>';
    if (mysqli_num_rows($query) > 0) {
        while ($rows = mysqli_fetch_assoc($query)) {
            $property_id = $rows['property_id'];
?>

<div class="col-sm-2">
<div class="card">
<?php
            $sql2 = "SELECT * FROM property_photo WHERE property_id='$property_id'";
            $query2 = mysqli_query($db, $sql2);

            if (mysqli_num_rows($query2) > 0) {
                $row = mysqli_fetch_assoc($query2); 
                $photo = $row['p_photo'];
                echo '<img class="image" src="owner/'.$photo.'">';
            }
?>
  <h4><b><?php echo $rows['property_type']; ?></b></h4> 
  <p><?php echo $rows['city'].', '.$rows['district'] ?></p> 
  <p><?php echo '<a href="view-property-login.php?property_id='.$rows['property_id'].'" class="btn btn-lg btn-primary btn-block">View Property</a><br>'; ?></p><br>
</div>
</div>

<?php 
        }
    } else {
        echo "<center><h3>Searched Property not found...</h3></center>";
    }
}
?>

</body>
</html>
