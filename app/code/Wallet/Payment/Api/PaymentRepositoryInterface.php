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

namespace Wallet\Payment\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface PaymentRepositoryInterface
{


    /**
     * Save Payment
     * @param \Wallet\Payment\Api\Data\PaymentInterface $payment
     * @return \Wallet\Payment\Api\Data\PaymentInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Wallet\Payment\Api\Data\PaymentInterface $payment
    );

    /**
     * Retrieve Payment
     * @param string $paymentId
     * @return \Wallet\Payment\Api\Data\PaymentInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($paymentId);

    /**
     * Retrieve Payment matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Wallet\Payment\Api\Data\PaymentSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Payment
     * @param \Wallet\Payment\Api\Data\PaymentInterface $payment
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Wallet\Payment\Api\Data\PaymentInterface $payment
    );

    /**
     * Delete Payment by ID
     * @param string $paymentId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($paymentId);
}
