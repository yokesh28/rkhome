<?php
namespace Wallet\Payment\Model;

use Magento\Framework\Model\AbstractModel;

class Friend extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Wallet\Payment\Model\Resource\Cashback');
    }
}