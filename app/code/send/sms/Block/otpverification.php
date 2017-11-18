<?php
namespace send\sms\Block;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class otpverification extends \Magento\Framework\View\Element\Template
{

public function checkotp(){
    
//db connection

$user_name = $_GET ['getotp'];

$this->_resources = \Magento\Framework\App\ObjectManager::getInstance()
->get('Magento\Framework\App\ResourceConnection');	
$connection= $this->_resources->getConnection();
$tableName = $this->_resources->getTableName('otpp');
    
$ckotp = $user_name;

$dates = date("Y-m-d");

    // SELECT DATA
$sql = "SELECT * FROM otpp WHERE `otp`='$ckotp' AND `dates`='$dates'";
$result = $connection->fetchall($sql); 
    
$cd = $result[0];

$dc = $cd['otp'];

if($dc == $ckotp){
    echo "Your mobile number verified";
}
else{
    echo "Invalid Otp";
}
    
$connection->query($sql); 
}


}

