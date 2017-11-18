<?php
namespace Wallet\Payment\Block;


use Magento\Framework\View\Element\Template\Context;
use Wallet\Payment\Model\Data;
use Magento\Framework\View\Element\Template;


class Hello extends Template
{
        
	public function __construct(Context $context, Data $model)
	{
                $this->model = $model;
		parent::__construct($context);
                
	}
   
        public function getHelloCollection()
        {
            $helloCollection = $this->model->getCollection();
            return $helloCollection;
        }
}