<?php
/**
 * Payment module
 * Copyright (C) 2017  I Visual
 * 
 * This file is part of Wallet/Payment.
 * 
 * Wallet/Payment is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Wallet\Payment\Model;

use Wallet\Payment\Api\Data\PaymentInterface;

class Payment extends \Magento\Framework\Model\AbstractModel implements PaymentInterface
{

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Wallet\Payment\Model\ResourceModel\Payment');
    }

    /**
     * Get payment_id
     * @return string
     */
    public function getPaymentId()
    {
        return $this->getData(self::PAYMENT_ID);
    }

    /**
     * Set payment_id
     * @param string $paymentId
     * @return \Wallet\Payment\Api\Data\PaymentInterface
     */
    public function setPaymentId($paymentId)
    {
        return $this->setData(self::PAYMENT_ID, $paymentId);
    }

    /**
     * Get money
     * @return string
     */
    public function getMoney()
    {
        return $this->getData(self::MONEY);
    }

    /**
     * Set money
     * @param string $money
     * @return \Wallet\Payment\Api\Data\PaymentInterface
     */
    public function setMoney($money)
    {
        return $this->setData(self::MONEY, $money);
    }
}
