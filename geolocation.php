<?php


// Initialize cURL
$curl = curl_init();

// Set the API endpoint URL
$url = 'http://ip-api.com/json';

// Set cURL options
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// Execute the cURL request
$response = curl_exec($curl);

// Check for cURL errors
if (curl_errno($curl)) {
  $errorMessage = curl_error($curl);
  // Handle the error
  echo 'Error: ' . $errorMessage;
} else {
  // Decode the JSON response
  $ipInfo = json_decode($response, true);
  $location= $ipInfo['country'];
  $regionName= $ipInfo['regionName'];
  $city= $ipInfo['city'];
  $zip= $ipInfo['zip'];
  $isp= $ipInfo['isp'];
  $query= $ipInfo['query'];
  // Display the response
  echo '<strong> Location:</strong> '  . $location . "<br>";
  echo '<strong>State:</strong> ' . $regionName . "<br>";
  echo '<strong>City:</strong> ' . $city . "<br>";
  echo '<strong>Pincode:</strong> ' . $zip . "<br>";
  echo '<strong>Internet Service Provider:</strong> ' . $isp . "<br>";
  echo '<strong>IP Address:</strong> ' . $query . "<br>";

}

// Close cURL
curl_close($curl);
?>
