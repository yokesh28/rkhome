<?php
namespace Wallet\Payment\Model\Resource;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Cashback extends AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('Cashback_Details', 'id');  // friends is name of table
    }
}