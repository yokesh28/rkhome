<?php
namespace Wallet\Payment\Model\Resource\Cashback;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'Wallet\Payment\Model\Cashback',
            'Wallet\Payment\Model\Resource\Cashback'
        );
    }
}