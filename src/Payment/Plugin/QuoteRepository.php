<?php
/**
 * Copyright 2016 Amazon.com, Inc. or its affiliates. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 *  http://aws.amazon.com/apache2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */
namespace Amazon\Payment\Plugin;

use Amazon\Payment\Api\Data\QuoteLinkInterfaceFactory;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\Data\CartExtensionFactory;
use Magento\Quote\Api\Data\CartInterface;

class QuoteRepository
{
    /**
     * @var CartExtensionFactory
     */
    protected $cartExtensionFactory;

    /**
     * @var QuoteLinkInterfaceFactory
     */
    protected $quoteLinkFactory;

    public function __construct(
        CartExtensionFactory $cartExtensionFactory,
        QuoteLinkInterfaceFactory $quoteLinkFactory
    ) {
        $this->cartExtensionFactory = $cartExtensionFactory;
        $this->quoteLinkFactory     = $quoteLinkFactory;
    }

    public function afterGet(CartRepositoryInterface $cartRepository, CartInterface $cart)
    {
        $this->setAmazonOrderReferenceIdExtensionAttribute($cart);

        return $cart;
    }

    public function afterGetForCustomer(CartRepositoryInterface $cartRepository, CartInterface $cart)
    {
        $this->setAmazonOrderReferenceIdExtensionAttribute($cart);

        return $cart;
    }

    public function afterGetActive(CartRepositoryInterface $cartRepository, CartInterface $cart)
    {
        $this->setAmazonOrderReferenceIdExtensionAttribute($cart);

        return $cart;
    }

    public function afterGetActiveForCustomer(CartRepositoryInterface $cartRepository, CartInterface $cart)
    {
        $this->setAmazonOrderReferenceIdExtensionAttribute($cart);

        return $cart;
    }

    protected function setAmazonOrderReferenceIdExtensionAttribute(CartInterface $cart)
    {
        $cartExtension = ($cart->getExtensionAttributes()) ?: $this->cartExtensionFactory->create();

        $amazonQuote = $this->quoteLinkFactory->create();
        $amazonQuote->load($cart->getId(), 'quote_id');

        if ($amazonQuote->getId()) {
            $cartExtension->setAmazonOrderReferenceId($amazonQuote->getAmazonOrderReferenceId());
        }

        $cart->setExtensionAttributes($cartExtension);
    }
}
