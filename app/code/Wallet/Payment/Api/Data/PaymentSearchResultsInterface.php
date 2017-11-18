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

namespace Wallet\Payment\Api\Data;

interface PaymentSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{


    /**
     * Get Payment list.
     * @return \Wallet\Payment\Api\Data\PaymentInterface[]
     */
    public function getItems();

    /**
     * Set money list.
     * @param \Wallet\Payment\Api\Data\PaymentInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
