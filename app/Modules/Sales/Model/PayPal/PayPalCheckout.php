<?php

namespace ChingShop\Modules\Sales\Model\PayPal;

use ChingShop\Modules\Sales\Model\Basket\Basket;
use ChingShop\Modules\Sales\Model\Basket\BasketItem;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ShippingAddress;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;

/**
 * Class PayPalCheckout.
 */
class PayPalCheckout
{
    const DEFAULT_CURRENCY = 'GBP';

    /** @var Basket */
    private $basket;

    /** @var ApiContext */
    private $apiContext;

    /**
     * @param Basket     $basket
     * @param ApiContext $apiContext
     */
    public function __construct(Basket $basket, ApiContext $apiContext)
    {
        $this->basket = $basket;
        $this->apiContext = $apiContext;
    }

    /**
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function approvalUrl(): string
    {
        return (string) $this->payment()
            ->create($this->apiContext)
            ->getApprovalLink();
    }

    /**
     * @throws \InvalidArgumentException
     *
     * @return Payer
     */
    protected function payer(): Payer
    {
        return (new Payer())->setPaymentMethod('paypal');
    }

    /**
     * @throws \InvalidArgumentException
     *
     * @return ItemList
     */
    private function itemList(): ItemList
    {
        return (new ItemList())->setItems(
            array_map(
                function (BasketItem $basketItem) {
                    $item = new Item();
                    $item->setName($basketItem->productOption->fullName())
                        ->setQuantity(1)
                        ->setCurrency(self::DEFAULT_CURRENCY)
                        ->setSku($basketItem->productOption->id)
                        ->setPrice($basketItem->productOption->priceAsFloat());

                    return $item;
                },
                $this->basket->basketItems->all()
            )
        )->setShippingAddress($this->shippingAddress());
    }

    /**
     * @throws \InvalidArgumentException
     *
     * @return ShippingAddress
     */
    private function shippingAddress(): ShippingAddress
    {
        return (new ShippingAddress())
            ->setRecipientName($this->basket->address->name)
            ->setLine1($this->basket->address->line_one)
            ->setLine2($this->basket->address->line_two)
            ->setCity($this->basket->address->city)
            ->setPostalCode($this->basket->address->post_code)
            ->setCountryCode($this->basket->address->country_code);
    }

    /**
     * @throws \InvalidArgumentException
     *
     * @return Details
     */
    private function details(): Details
    {
        return (new Details())
            ->setShipping(0)
            ->setTax(0)
            ->setSubtotal($this->basket->totalPrice());
    }

    /**
     * @throws \InvalidArgumentException
     *
     * @return Amount
     */
    private function amount(): Amount
    {
        return (new Amount())
            ->setCurrency(self::DEFAULT_CURRENCY)
            ->setTotal($this->basket->totalPrice())
            ->setDetails($this->details());
    }

    /**
     * @throws \InvalidArgumentException
     *
     * @return Transaction
     */
    private function transaction(): Transaction
    {
        return (new Transaction())
            ->setAmount($this->amount())
            ->setItemList($this->itemList())
            ->setDescription('TODO')
            ->setInvoiceNumber($this->basket->id);
    }

    /**
     * @throws \InvalidArgumentException
     *
     * @return RedirectUrls
     */
    private function redirectUrls(): RedirectUrls
    {
        return (new RedirectUrls())
            ->setReturnUrl(
                route('sales.customer.paypal.return')
            )
            ->setCancelUrl(
                route('sales.customer.paypal.cancel')
            );
    }

    /**
     * @throws \InvalidArgumentException
     *
     * @return Payment
     */
    private function payment(): Payment
    {
        return (new Payment())
            ->setIntent('sale')
            ->setPayer($this->payer())
            ->setRedirectUrls($this->redirectUrls())
            ->setTransactions([$this->transaction()]);
    }
}
