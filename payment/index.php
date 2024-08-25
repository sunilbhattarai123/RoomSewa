<?php

session_start();
if(isset($_POST['property_id'])){
    $property_id=$_POST['property_id'];
    $_SESSION['property_id']=$property_id;
}
if(isset($_SESSION['email'])){


$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://a.khalti.com/api/v2/epayment/initiate/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => '{
        "return_url": "http://localhost/simplirentrps/booking-engine.php",
        "website_url": "http://localhost/simplirentrps",
        "amount": "20000",
        "purchase_order_id": "test01",
        "purchase_order_name": "test",
        "customer_info": {
            "name": "Ramesh Bhattarai",
            "email": "test@khalti.com",
            "phone": "9800000002"
        }
    }',
    CURLOPT_HTTPHEADER => array(
        'Authorization: key live_secret_key_68791341fdd94846a146f0457ff7b455',
        'Content-Type: application/json',
    ),
));

$response = curl_exec($curl);

curl_close($curl);

// Check if cURL request was successful
if ($response === false) {
    die('Curl error: ' . curl_error($curl));
}

// Decode the JSON response
$data = json_decode($response, true);

// Check if decoding was successful
if ($data === null) {
    die('Error decoding JSON response');
}

// Check if the payment URL is present in the response
if (isset($data['payment_url'])) {
    // Redirect the user to the payment URL
    header('Location: ' . $data['payment_url']);
} else  {
    // Handle the case where the payment URL is not present in the response
    echo 'Error: Payment URL not found in the response';
}
}