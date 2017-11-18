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

use Wallet\Payment\Api\PaymentRepositoryInterface;
use Wallet\Payment\Api\Data\PaymentSearchResultsInterfaceFactory;
use Wallet\Payment\Api\Data\PaymentInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Wallet\Payment\Model\ResourceModel\Payment as ResourcePayment;
use Wallet\Payment\Model\ResourceModel\Payment\CollectionFactory as PaymentCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class PaymentRepository implements paymentRepositoryInterface
{

    protected $resource;

    protected $paymentFactory;

    protected $paymentCollectionFactory;

    protected $searchResultsFactory;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $dataPaymentFactory;

    private $storeManager;


    /**
     * @param ResourcePayment $resource
     * @param PaymentFactory $paymentFactory
     * @param PaymentInterfaceFactory $dataPaymentFactory
     * @param PaymentCollectionFactory $paymentCollectionFactory
     * @param PaymentSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResourcePayment $resource,
        PaymentFactory $paymentFactory,
        PaymentInterfaceFactory $dataPaymentFactory,
        PaymentCollectionFactory $paymentCollectionFactory,
        PaymentSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->paymentFactory = $paymentFactory;
        $this->paymentCollectionFactory = $paymentCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataPaymentFactory = $dataPaymentFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Wallet\Payment\Api\Data\PaymentInterface $payment
    ) {
        /* if (empty($payment->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $payment->setStoreId($storeId);
        } */
        try {
            $payment->getResource()->save($payment);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the payment: %1',
                $exception->getMessage()
            ));
        }
        return $payment;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($paymentId)
    {
        $payment = $this->paymentFactory->create();
        $payment->getResource()->load($payment, $paymentId);
        if (!$payment->getId()) {
            throw new NoSuchEntityException(__('Payment with id "%1" does not exist.', $paymentId));
        }
        return $payment;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->paymentCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'store_id') {
                    $collection->addStoreFilter($filter->getValue(), false);
                    continue;
                }
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($collection->getItems());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \Wallet\Payment\Api\Data\PaymentInterface $payment
    ) {
        try {
            $payment->getResource()->delete($payment);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Payment: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($paymentId)
    {
        return $this->delete($this->getById($paymentId));
    }
}
