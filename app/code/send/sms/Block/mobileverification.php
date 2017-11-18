<?php

namespace send\sms\Block;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class mobileverification extends \Magento\Framework\View\Element\Template
{
   
  
public function checknumber(){
    
//db connection
$this->_resources = \Magento\Framework\App\ObjectManager::getInstance()
->get('Magento\Framework\App\ResourceConnection');	
$connection= $this->_resources->getConnection();
$tableName = $this->_resources->getTableName('otpp');

$dates = date("Y-m-d");

$phone = $_POST["phone"];

$randcode = rand(100000, 999999);

// SELECT DATA
$sql = "SELECT otp FROM otpp WHERE `phone`='$phone'";
$result = $connection->fetchall($sql); 

   if(!empty($result)){ 
// if already exists

$code = $result[0];
$otppass = $code['otp'];

echo "Something went wrong! Try again ";
}
else{
    //insert data
$sql = "INSERT INTO " . $tableName . "(phone, otp, dates) VALUES ('$phone', '$randcode', '$dates')";

$YourAPIKey='1c3c98a2-ace2-11e7-94da-0200cd936042';
$OTP=$randcode;
$SentTo=$phone;


### DO NOT Change anything below this line
$agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
$url = "https://2factor.in/API/V1/$YourAPIKey/SMS/$SentTo/$OTP"; 
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL,$url); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, $agent);
echo curl_exec($ch); 
curl_close($ch);


} 


$connection->query($sql);


}

public function checkotp(){
    
     $om = \Magento\Framework\App\ObjectManager::getInstance();
     $customerSession = $om->get('Magento\Customer\Model\Session');
     if($customerSession->isLoggedIn()) {
      $customerId=   $customerSession->getCustomer()->getId();
//db connection
$this->_resources = \Magento\Framework\App\ObjectManager::getInstance()
->get('Magento\Framework\App\ResourceConnection');	
$connection= $this->_resources->getConnection();
$tableName = $this->_resources->getTableName('otpp');
    
$ckotp = $_POST["getotp"];

$dates = date("Y-m-d");

    // SELECT DATA
$sql = "SELECT * FROM otpp WHERE `otp`='$ckotp' AND `dates`='$dates'";
$result = $connection->fetchall($sql); 
    
$cd = $result[0];

$dc = $cd['otp'];

if($dc == $ckotp){
    

  $om = \Magento\Framework\App\ObjectManager::getInstance();
$customerSession = $om->create('Magento\Customer\Model\Session');
if($customerSession->isLoggedIn()) 
{
      $customerId = $customerSession->getCustomer()->getId();
}
    $sql = "INSERT INTO " . $tableName . "(phone, otp, dates,cust_id) VALUES ('$phone', '$randcode', '$dates', '$customerId')";

    echo "<div class='success'>";
    echo "Your mobile number verified";
    echo "</div>";
     }
}
else{
    echo "Invalid Otp";
}
    
$connection->query($sql); 
}




}