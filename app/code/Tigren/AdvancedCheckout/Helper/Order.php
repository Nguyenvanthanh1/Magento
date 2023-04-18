<?php

namespace Tigren\AdvancedCheckout\Helper;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;

class Order extends AbstractHelper
{
    private CollectionFactory $orderCollection;
    private Session $customerSession;

    public function __construct(Session $customerSession, CollectionFactory $orderCollection, Context $context)
    {
        parent::__construct($context);
        $this->orderCollection = $orderCollection;
        $this->customerSession = $customerSession;
    }

    public function checkStatusOrder()
    {
        if ($this->getCustomerId()) {
            $orderByCustomerId = $this->orderCollection->create($this->getCustomerId());
            if (!empty($orderByCustomerId)) {
                foreach ($orderByCustomerId as $order) {
                    if ($order->getStatus() !== 'complete') {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function getCustomerId()
    {
        return $this->customerSession->getCustomer() ? $this->customerSession->getCustomerId() : '';
    }
}
