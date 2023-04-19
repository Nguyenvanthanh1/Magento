<?php

namespace Tigren\AdvancedCheckout\Observer;

use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Store\Model\StoreManagerInterface;
use Tigren\AdvancedCheckout\Helper\Order;
use Magento\Customer\Model\AddressFactory;

class CreateCustomer implements ObserverInterface
{
    private Order $orderHelper;
    private CustomerFactory $customerFactory;
    private StoreManagerInterface $storeManager;
    private AddressFactory $addressFactory;

    public function __construct(
        CustomerFactory $customerFactory,
        StoreManagerInterface $storeManager,
        Order $orderHelper,
        AddressFactory $addressFactory
    ) {
        $this->orderHelper = $orderHelper;
        $this->customerFactory = $customerFactory;
        $this->storeManager = $storeManager;
        $this->addressFactory = $addressFactory;
    }

    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $address = $order->getShippingAddress();
        $customer = $this->customerFactory->create();
        if ($order->getCustomerIsGuest()) {
                    /** @var \Magento\Sales\Model\Order\Address $address */
                    if ($address->getAddressType() === 'shipping') {
                        $customer->setEmail($address->getEmail());
                        $customer->setStore($this->storeManager->getStore());
                        $customer->setWebsiteId($this->storeManager->getStore()->getWebsiteId());
                        $customer->setData('firstname',$address->getFirstName());
                        $customer->setData('lastname',$address->getLastName());
                        $customer->setGroupId(1);
                        $customer->setPassword('123456');
                        $customer->save();
                    }
                    if($customer->getCustomerId()){
                        $address = $this->addressFactory->create();
                        $address->setCustomerId($customer->getId());
                        $address->setFirstname($address->getFirstname());
                        $address->setLastname($address->getLastname());
                        $address->setTelephone($address->getTelephone());
                        $address->setCountryId($address->getCountryId());
                        $address->setPostcode($address->getPostcode());
                        $address->setCity($address->getCity());
                        $address->setStreet($address->getStreet());
                        $address->setIsDefaultBilling(true);
                        $address->setIsDefaultShipping(true);
                        $address->save();
                        $order->setCustomerId($customer->getId());
                        $order->save();
                    }
        }
        return $this;
    }
}
