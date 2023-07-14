<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);


$conn = mysqli_connect('localhost', 'root', 'root');

// if($conn){
//     echo "Connection successful";
// }else{
//     echo "Not successful";
// }
mysqli_select_db($conn, 'etm');


// function to fetch api
function getLocationData($ip) {
    $curl = curl_init();
    $url = "http://ip-api.com/json/";

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        $errorMessage = curl_error($curl);
        // Handle the error
        echo 'Error: ' . $errorMessage;
        return null;
    } else {
        $locationInfo = json_decode($response, true);
        // Extract the required location data
        $locationData = array(
            'country' => $locationInfo['country'],
            'state' => $locationInfo['regionName'],
            'city' => $locationInfo['city'],
            'zip' => $locationInfo['zip'],
            'isp' => $locationInfo['isp'],
            'query' => $locationInfo['query']
        );

        return $locationData;
    }

    curl_close($curl);
}

// Fetch the user's location from the IP
if(isset($_POST['checkboxT&C'])){
    $locationData = getLocationData($ip);
    
    // Extract location details
    $country = isset($locationData['country']) ? $locationData['country'] : '';
    $state = isset($locationData['state']) ? $locationData['state'] : '';
    $city = isset($locationData['city']) ? $locationData['city'] : '';
    $zip = isset($locationData['zip']) ? $locationData['zip'] : '';
    $isp = isset($locationData['isp']) ? $locationData['isp'] : '';
    $query = isset($locationData['query']) ? $locationData['query'] : '';

}



$email = mysqli_real_escape_string($conn, $_POST['email']);
$name = mysqli_real_escape_string($conn, $_POST['name']);
$role = mysqli_real_escape_string($conn, $_POST['role']);
$department = mysqli_real_escape_string($conn, $_POST['department']);
$defaultImage = 'default_profile.jpg';
$password = mysqli_real_escape_string($conn, $_POST['password']);
if (strlen($password) < 8) {
    // Password Hashing
    $errorMessageforshortpass = "Password must be at least 8 characters long";
    header("location: register.php?errorMessageforshortpass=" . urlencode($errorMessageforshortpass));
}else{
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
}

$number = mysqli_real_escape_string($conn, $_POST['number']);

// less secure way to generate a token:

// $varforToken = rand(10000000000, 9999999999);
// $token = uniqid($varforToken);

// generating token in a more secure way
$token = bin2hex(random_bytes(16));

$timestamp = date('Y-m-d H:i:s'); 




// Email and number validation for uniqueness
$ifemailexistcheck = "SELECT email from registrationdata WHERE email = '$email'";
$ifemailexistcheckresult = mysqli_query($conn, $ifemailexistcheck);

$ifnumberexistcheck = "SELECT number from registrationdata WHERE number = '$number'";
$ifnumberexistcheckresult = mysqli_query($conn, $ifnumberexistcheck);

if(mysqli_num_rows($ifemailexistcheckresult)>0){
    $errorMessageforEmail= "This email is already registered";
    header("location: register.php?errorMessageforEmail=" . urlencode($errorMessageforEmail));
}elseif(mysqli_num_rows($ifnumberexistcheckresult)>0){
        $errorMessageforNumber= "This number is already registered";
        header("location: register.php?errorMessageforNumber=". urlencode($errorMessageforNumber));
}
// ends here


// vaidation for empty field is started
elseif(empty($email)){
    $errorMessageforEmailempty = "Email is a required field";
    header("location:register.php?errorMessageforEmailempty=" .urlencode($errorMessageforEmailempty));
}elseif(empty($name)){
    $errorMessageforNameempty= "Name is a required field";
    header("location:register.php?errorMessageforNameempty=" . urlencode($errorMessageforNameempty));
}elseif(empty($number)){
    $errorMessageforNumberempty = "Number is a required field";
    header("location:register.php?errorMessageforNumberempty=" . urlencode($errorMessageforNumberempty));
}elseif(empty($password)){
    $errorMessageforPasswordempty = "Password is a required field";
    header("location:register.php?errorMessageforPasswordempty=" . urlencode($errorMessageforPasswordempty));
}
// ends here


// validation for valid email
elseif(strpos($email, '@')===false){
    $errorMessageformissingsign = "This email does not include '@' sign";
    header("location:register.php?errorMessageformissingsign=" . urlencode($errorMessageformissingsign));
}elseif(strpos($email, '.')=== false){
    $errorMessageformissingdotsign = "This email does not include ' . ' sign";
    header("location:register.php?errorMessageformissingdotsign=" . urlencode($errorMessageformissingdotsign));
}elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errormessageforInvalidEmail = "This email is not valid. Please input a valid email";
    header("location:register.php?errormessageforInvalidEmail=" . urlencode($errormessageforInvalidEmail));
}
// ends here

// validation for valid number
elseif(!preg_match('/^\d{10}$/', $number)){
    $errormessageforInvalidNumber = "This number is not valid";
    header("location:register.php?errormessageforInvalidNumber=" . urlencode($errormessageforInvalidNumber));
}elseif($role === 'admin'){
    $query= "INSERT INTO registrationdata (email, name, number, password, role,  country, state, city, zip, isp, ipAddress, token, profile,  created_at, updated_at)
                VALUES ('$email', '$name', '$number', '$hashedPassword', '$role',  '$country', '$state', '$city', '$zip', '$isp', '$query', '$token', '$defaultImage', '$timestamp', '$timestamp')";

    $successful = mysqli_query($conn, $query);

    if ($successful) {
        header("location:register.php?status=success");
    } else {
        header("location:register.php?status=error");
    }
    exit();
}

else{
    $query= "INSERT INTO registrationdata (email, name, number, password, role, department, country, state, city, zip, isp, ipAddress, token, profile,  created_at, updated_at)
                VALUES ('$email', '$name', '$number', '$hashedPassword', '$role', '$department', '$country', '$state', '$city', '$zip', '$isp', '$query', '$token', '$defaultImage', '$timestamp', '$timestamp')";

    $successful = mysqli_query($conn, $query);

    if ($successful) {
        header("location:register.php?status=success");
    } else {
        header("location:register.php?status=error");
    }
    exit();
}

// ends here


























?>