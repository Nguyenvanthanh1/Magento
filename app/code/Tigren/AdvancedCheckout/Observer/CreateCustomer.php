<?php

namespace Tigren\AdvancedCheckout\Observer;

use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Store\Model\StoreManagerInterface;
use Tigren\AdvancedCheckout\Helper\Order;

class CreateCustomer implements ObserverInterface
{
    private Order $orderHelper;
    private CustomerFactory $customerFactory;
    private StoreManagerInterface $storeManager;

    public function __construct(
        CustomerFactory $customerFactory,
        StoreManagerInterface $storeManager,
        Order $orderHelper,
    ) {
        $this->orderHelper = $orderHelper;
        $this->customerFactory = $customerFactory;
        $this->storeManager = $storeManager;
    }

    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $bothAddress = $order->getAddresses();
        if ($order->getCustomerIsGuest()) {
            if (!empty($bothAddress)) {
                foreach ($bothAddress as $address) {
                    /** @var \Magento\Sales\Model\Order\Address $address */
                    if ($address->getAddressType() === 'shipping' || $address->getAddressType() === 'billing') {
                        $customer = $this->customerFactory->create();
                        $customer->setEmail($address->getEmail());
                        $customer->setFirstName($address->getFirstName());
                        $customer->setLastName($address->getLastName());
                        $customer->setMiddleName($address->getMiddleName());
                        $customer->setGroupId(1);
                        $customer->setDefaultBilling(1);
                        $customer->setDefaultShipping(1);
                        $customer->setPassword($customer->encryptPassword('123456'));
                        $customer->save();
                        break;
                    }
                }
            }
        }
        return $this;
    }
}
