 <?php

$servername = "localhost";
$username   = "rkhomeap_siva";
$password   = "siva1341";
$dbname     = "rkhomeap_rk";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);


$dates = date("Y-m-d");

$phone = $_POST["phone"];



if (isset($_POST['send'])) {
    session_start();


    $sql = "SELECT * FROM otpp WHERE phone = '$phone' AND dates = '$dates'";
    
    $result = mysqli_query($conn, $sql);
    
    
    $count = mysqli_num_rows($result);
    // if already exists ?
    if ($count > 0) {
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $otppass = $row["otp"];
            $to = $row["phone"];
           
            
            $YourAPIKey='1c3c98a2-ace2-11e7-94da-0200cd936042';
$OTP=$otppass;
$SentTo=$to;


### DO NOT Change anything below this line
$agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
$url = "https://2factor.in/API/V1/$YourAPIKey/SMS/$SentTo/$OTP"; 
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL,$url); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, $agent);
curl_exec($ch); 
curl_close($ch);

             $_SESSION['code'] = $otppass; // store code for later
            /*    
             *  phone number in today already exists
             *  so here we have to get otp and send to that phone
             */
            
        } else {
            echo "0 results";
        }
        
    } else {
        // otherwise      
        // insert data 
        //generate otp
        $code = rand(100000, 999999);
         $to = $row["phone"];
         // store code for later
        
        
        $YourAPIKey='1c3c98a2-ace2-11e7-94da-0200cd936042';
$OTP=$code;
$SentTo=$to;


### DO NOT Change anything below this line
$agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
$url = "https://2factor.in/API/V1/$YourAPIKey/SMS/$SentTo/$OTP"; 
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL,$url); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, $agent);
curl_exec($ch); 
curl_close($ch);

        $sql = "INSERT INTO otpp (phone, otp, dates)
        VALUES ('$phone', '$code', '$dates')";
        
        if ($conn->query($sql) === TRUE) {
            $_SESSION['code'] = $code;

            //send otp here
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

if (isset($_POST['save'])) {
session_start();


if ($_SESSION['code'] == $_POST['getotp']) {
    echo "OTP matchs";
}else{
    echo "Invalid OTP";
}

            
} 
    


?>


<!doctype html>
<html>
 <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="$1">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="style.css">

    <title>test</title>

</head>
<body>

    <form method="post"> 

    <label id="first"> Phone:</label><br/>
    <input type="tel" name="phone"><br/>
    <button type="submit" name="send">send</button><br/>
    

    <label id="first"> Enter otp:</label><br/>
    <input type="text" name="getotp"><br/>
    <button type="submit" name="save">check</button><br/>
    
    </form>


</body>
</html>




