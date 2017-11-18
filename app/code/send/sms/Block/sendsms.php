<?php



namespace send\sms\Block;

class sendsms extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;

    /**
     * @var int
     */
    protected $oderId;
    
    protected $_customerSession;
    /**
     * @var array
     */
    protected $lastOrder;
    
    protected $orderPrice;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Customer\Model\Session $customerSession,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->checkoutSession = $checkoutSession;
        $this->_customerSession = $customerSession;
    }

    protected function _prepareLayout()
    {
        $lastOrder = $this->checkoutSession->getLastRealOrder();
        $this->orderId = $lastOrder->getIncrementId();
        $this->lastOrder = $lastOrder->getData();
        return parent::_prepareLayout();
    }
    
    public function getOrderId()
    {
        return $this->orderId; 
    }
    public function getLastOrder()
    {
        return $this->lastOrder;
    }
    
  public function getOrderDetails($incrementId)
{
    $orderDetail = $this->order->loadByIncrementId($incrementId);
    return $orderDetail;
}
  

public function categorymsg(){

$orderId = $this->getOrderId();

$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
$order = $objectManager->create('Magento\Sales\Model\Order')->loadByIncrementId($orderId);

$shippingAddress = $order->getShippingAddress(); //address
$fname = $order->getCustomerFirstname(); //name
$pphone = $shippingAddress->getTelephone(); //phone
$price = $order->getGrandTotal()-00; //price
$items = $order->getAllVisibleItems();

foreach($items as $i):
    
    $_product = $objectManager->create('Magento\Catalog\Model\Product')->load($i->getProductId());
    $categoryIds = $_product->getCategoryIds();

endforeach;

$payment = $order->getPayment();
   $method = $payment->getMethodInstance();
   $methodTitle = $method->getTitle();
  
    
    if (in_array(77, $categoryIds)  )
  {
      if($methodTitle != "Cash On Delivery"){
$TemplateName = "product_paysms";
}
else{
      $TemplateName = "normal_products"; 
}
}
elseif(in_array(77, $categoryIds)){

 if($methodTitle = "Cash On Delivery"){
          $TemplateName = "SchemesSuccess";  //For Cash on delivery sms
    }else{
         $TemplateName = "cod_sms";  //For bank transfer sms
    }
} else
  {
       if($methodTitle = "Cash On Delivery"){
         $TemplateName = "normal_products";  //For Cash on delivery sms
    }else{
         $TemplateName = "product_paysms ";  //For bank transfer sms
    }
  }
$productnames =  "";
$YourAPIKey='1c3c98a2-ace2-11e7-94da-0200cd936042';
$From="RKHOME";
$To=$pphone; //phone number
$VAR1=$fname;   //first name
$VAR2=$orderId; //order id
$VAR3=$methodTitle;//here is the items 
$VAR4=" " . $price; // total price

$VAR5="https://rkhomeappliances.co.in/"; // website link

### DO NOT Change anything below this line
$agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
$url = "https://2factor.in/API/V1/$YourAPIKey/ADDON_SERVICES/SEND/TSMS"; 
$ch = curl_init(); 
curl_setopt($ch,CURLOPT_URL,$url); 
curl_setopt($ch,CURLOPT_POST,true); 
curl_setopt($ch,CURLOPT_POSTFIELDS,"TemplateName=$TemplateName&From=$From&To=$To&VAR1=$VAR1&VAR2=$VAR2&VAR3=$VAR3&VAR4=$VAR4");
curl_setopt($ch, CURLOPT_USERAGENT, $agent);
echo '<div style="color:white;">';
echo curl_exec($ch); 
echo '</div>';
curl_close($ch);
 
}
   
    public function walletdiscount(){

$total_datas = $this->getLastOrder(); 
$total_datas['entity_id']; // order id
$total_datas['customer_id']; // customer id
$total_datas['created_at']; // date time

$total_datas['created_at'];


$orderId = $this->getOrderId();

$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
$order = $objectManager->create('Magento\Sales\Model\Order')->loadByIncrementId($orderId);

$price = $order->getGrandTotal();


$items = $order->getAllItems();

foreach($items as $item):
$prid = $item->getProductId();
     $_productname = 
$objectManager->create('Magento\Catalog\Model\Product')->load($prid)->getName();

$quantity_product = $item->getQtyOrdered();
$price_product = $item->getPrice();
//get product discount 
$this->_resources = \Magento\Framework\App\ObjectManager::getInstance()
->get('Magento\Framework\App\ResourceConnection');  
$connection= $this->_resources->getConnection();


$sql = "SELECT value FROM `catalog_product_entity_varchar` WHERE `attribute_id` = 167 AND `entity_id` = '$prid'";  //cashback money's

$result = $connection->fetchall($sql); 
$diss = $result['0'];
$product_dis = $diss['value'];  // product discount value for each product
$dis_amount  = ( $price_product / 100 ) * $product_dis; //product amount

$connection->query($sql);

$discount_for_product = $dis_amount * $quantity_product; //product discount amount with quantity
//get product validity date

$this->_resources = \Magento\Framework\App\ObjectManager::getInstance()
->get('Magento\Framework\App\ResourceConnection');  

$connection= $this->_resources->getConnection();

$sql = "SELECT value FROM `catalog_product_entity_varchar` WHERE `attribute_id` = 168 AND `entity_id` = '$prid'";  //cashback money's

$result = $connection->fetchall($sql); 

$daysto = $result['0'];
$approve = $daysto['value'];  // product discount validity for each product

$addedDays = $daysto['value'];

$phpdate = strtotime( $total_datas['created_at'] );  // created date

$mysqldate = date( 'Y-m-d', $phpdate ); //sortind date format 

$newDate = date('Y-m-d', strtotime($mysqldate. " + {$addedDays} days")); //add number of days

$today = $total_datas['created_at'];
$today = strtotime($today);
$finish = $newDate;
$finish = strtotime($finish);
    //difference
$diff = $finish - $today;

$daysleft=floor($diff/(60*60*24));
    
$days_to_approve = $daysleft;

$connection->query($sql);



$this->_resources = \Magento\Framework\App\ObjectManager::getInstance()
->get('Magento\Framework\App\ResourceConnection');  

$connection= $this->_resources->getConnection();

$orderid = $total_datas['entity_id'];
$created = $total_datas['created_at'];
$customerid = $total_datas['customer_id'];

$_prod_cats = $objectManager->create('Magento\Catalog\Model\Product')->load($prid)->getCategoryIds();

// if category is schemes
 $categoryIds = $_prod_cats;
if(in_array(77, $categoryIds)){
$schemeis = 1;  
}else{
$schemeis = 0;
}

$sql = "INSERT INTO  wallet_discounts (product_id, product_name, order_id, product_quantity, product_discount_amount, customer_id, created_at, days_to_approve, is_scheme) VALUES ('$prid', '$_productname', '$orderid', '$quantity_product', '$discount_for_product', '$customerid', '$created', '$days_to_approve', '$schemeis')";


$connection->query($sql);

if(in_array(77, $categoryIds)){
    echo "<h3>Your Scheme " . $_productname . "Is Booked Successfully</h3>";
}else{
    echo "<h3>Congratulations! Your discount amount for " . $_productname . " Rs " . $dis_amount . " of cashback amount is added, check your wallet balance.</h3>";
}



endforeach;


    }
 
 
 
 


   
     
}
