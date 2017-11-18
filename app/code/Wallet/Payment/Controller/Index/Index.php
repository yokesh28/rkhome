<?php


namespace Wallet\Payment\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Wallet\Payment\Model\CashbackFactory;

class Index extends \Magento\Framework\App\Action\Action
{
    
    protected $_modelFriendFactory;

    /**
     * @param Context $context
     * @param FriendFactory $modelFriendFactory
     */
    
     public function __construct(
        Context $context,
        CashbackFactory $modelFriendFactory
    ) {
        parent::__construct($context);
        $this->_modelFriendFactory = $modelFriendFactory;
    }


    public function execute()
    {

        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
         

        
    }
    
  
}