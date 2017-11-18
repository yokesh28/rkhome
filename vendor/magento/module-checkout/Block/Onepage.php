<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Checkout\Block;

/**
 * Onepage checkout block
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
 
 ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Onepage extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Framework\Data\Form\FormKey
     */
    protected $formKey;

    /**
     * @var bool
     */
    protected $_isScopePrivate = false;

    /**
     * @var array
     */
    protected $jsLayout;

    /**
     * @var \Magento\Checkout\Model\CompositeConfigProvider
     */
    protected $configProvider;

    /**
     * @var array|\Magento\Checkout\Block\Checkout\LayoutProcessorInterface[]
     */
    protected $layoutProcessors;

    protected $_customerSession;

    protected $_orderConfig;
    
    protected $checkoutSession;
    
    protected $oderId;

    protected $lastOrder;
    
    protected $orderPrice;
    
    protected $cart;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Data\Form\FormKey $formKey
     * @param \Magento\Checkout\Model\CompositeConfigProvider $configProvider
     * @param array $layoutProcessors
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Checkout\Model\CompositeConfigProvider $configProvider,
        \Magento\Customer\Model\Session $customerSession,
          \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Sales\Model\Order\Config $orderConfig,
        \Magento\Checkout\Model\Cart $cart,
       
        
        array $layoutProcessors = [],
        array $data = []
    ) {
        $this->formKey = $formKey;
        $this->_isScopePrivate = true;
        $this->jsLayout = isset($data['jsLayout']) && is_array($data['jsLayout']) ? $data['jsLayout'] : [];
        $this->configProvider = $configProvider;
        $this->layoutProcessors = $layoutProcessors;
        $this->_customerSession = $customerSession;
        $this->_orderConfig = $orderConfig;
        $this->checkoutSession = $checkoutSession;
        $this->cart = $cart;
         
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function getJsLayout()
    {
        foreach ($this->layoutProcessors as $processor) {
            $this->jsLayout = $processor->process($this->jsLayout);
        }
        return \Zend_Json::encode($this->jsLayout);
    }

    
    /**
     * Retrieve form key
     *
     * @return string
     * @codeCoverageIgnore
     */
    public function getFormKey()
    {
        return $this->formKey->getFormKey();
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
    
    /**
     * Retrieve checkout configuration
     *
     * @return array
     * @codeCoverageIgnore
     */
    public function getCheckoutConfig()
    {
        return $this->configProvider->getConfig();
    }

    /**
     * Get base url for block.
     *
     * @return string
     * @codeCoverageIgnore
     */
    public function getBaseUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl();
    }




public function deleteQuoteItems(){
    $checkoutSession = $this->getCheckoutSession();
    $allItems = $checkoutSession->getQuote()->getAllVisibleItems();//returns all teh items in session
    foreach ($allItems as $item) {
        $itemId = $item->getItemId();//item id of particular item
        $quoteItem=$this->getItemModel()->load($itemId);//load particular item which you want to delete by his item id
        $quoteItem->delete();//deletes the item
    }
}

public function getCheckoutSession(){
    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();//instance of object manager 
    $checkoutSession = $objectManager->get('Magento\Checkout\Model\Session');//checkout session
    return $checkoutSession;
}
 
public function getItemModel(){
    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();//instance of object manager
    $itemModel = $objectManager->create('Magento\Quote\Model\Quote\Item');//Quote item model to load quote item
    return $itemModel;
}

public function getPayDet(){
    $orderId = $this->getOrderId();
    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    $order = $objectManager->create('Magento\Sales\Model\Order')->loadByIncrementId($orderId);
    $payment = $order->getPayment();
    $method = $payment->getMethodInstance();
    $methodTitle = $method->getTitle();
    return $methodTitle;
    
    
}
 public function getInvoiceDetails($order_id){

   $orderdetails = $this->order->loadByIncrementId($order_id);
     return $orderdetails;
  }


public function getget(){
    
    /*$orderId = $this->getOrderId();

$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
$order = $objectManager->create('Magento\Sales\Model\Order')->loadByIncrementId($orderId);
     $payment = $order->getPayment();
    $method = $payment->getMethodInstance();
    $methodTitle = $method->getTitle();
    return $methodTitle;*/
    
    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    $cart = $objectManager->get('\Magento\Checkout\Model\Cart'); 
$quote = $cart->getQuote();

$method = $quote->getMethodInstance();

if ($method) {
   $method->getCode('PAYMENT_METHOD_CASHONDELIVERY_CODE');
   return $method;
}

//$payment->getCode();
    //return $payment;
    
    
    
}



}
