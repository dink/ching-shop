<?php

namespace ChingShop\Modules\Sales\Http\Controllers\Customer;

use ChingShop\Http\Controllers\Controller;
use ChingShop\Http\WebUi;
use ChingShop\Modules\Sales\Domain\Order;
use Jenssegers\Optimus\Optimus;

/**
 * Controller for viewing and managing orders.
 *
 * Class OrderController
 */
class OrderController extends Controller
{
    /** @var Order */
    private $orderResource;

    /** @var WebUi */
    private $webUi;

    /** @var Optimus */
    private $optimus;

    /**
     * OrderController constructor.
     *
     * @param Order $orderResource
     * @param WebUi $webUi
     */
    public function __construct(Order $orderResource, WebUi $webUi, Optimus $optimus)
    {
        $this->orderResource = $orderResource;
        $this->webUi = $webUi;
        $this->optimus = $optimus;
    }

    /**
     * @param int $orderId
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     *
     * @return string
     */
    public function viewAction(int $orderId)
    {
        return $this->webUi->view(
            'customer.orders.view',
            [
                'order' => $this->orderResource->findOrFail(
                    $this->optimus->decode($orderId)
                ),
            ]
        );
    }
}