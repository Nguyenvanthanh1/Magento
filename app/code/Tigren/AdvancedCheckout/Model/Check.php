<?php

namespace Tigren\AdvancedCheckout\Model;

use Tigren\AdvancedCheckout\Api\CheckStatusInterface;
use Tigren\AdvancedCheckout\Helper\Order;

class Check implements CheckStatusInterface
{
    private Order $orderHelper;

    public function __construct(Order $orderHelper)
    {
        $this->orderHelper = $orderHelper;
    }

    public function execute(bool $request)
    {
        $message = '';
        if ($request) {
            $status = $this->orderHelper->checkStatusOrder();
            if ($status) {
                $message = 'show';
            } else {
                $message = 'hide';
            }
        }
        return $message;
    }
}
