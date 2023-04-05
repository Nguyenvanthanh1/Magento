<?php

namespace Tigren\CustomerGroupCatalog\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\Rule\CollectionFactory;

/**
 * Observes the `checkout_cart_product_add_before` event.
 */
class AddToCart implements ObserverInterface
{
    protected $ruleCollection;

    public function __construct(CollectionFactory $ruleCollection)
    {
        $this->ruleCollection = $ruleCollection;
    }

    /**
     * Observer for checkout_cart_product_add_after.
     *
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(Observer $observer)
    {
        $event = $observer->getEvent();
        $product = $event->getProduct();
        $quote = $event->getQuoteItem();
        /** @var  \Magento\Catalog\Model\Product $product */
        $rules = $this->ruleCollection->create();
        $rules->addFieldToFilter('active', 1);
        $totalValidate = 0;
        $priority = [];
        $discountRulePriority = 0;
        try {
            foreach ($rules as $rule) {
                /* @var \Tigren\CustomerGroupCatalog\Model\Rule $rule */
                $validate = $rule->getConditions()->validate($product);
                if ($validate === true) {
                    $priority[] = $rule->getPriority();
                    $totalValidate++;
                }
                if ($validate && $totalValidate === 1) {
                    $discountRulePriority = $rule->getDiscountAmount();
                }
                if ($validate && $totalValidate > 1 && !empty($priority) && count($priority) > 1 && $rule->getPriority() === min($priority)) {
                    $discountRulePriority = $rule->getDiscountAmount();
                }
            }
            $finalPrice = (int)$quote->getProduct()->getFinalPrice();
            $priceDiscount = $finalPrice - ($finalPrice / 100 * (int)$discountRulePriority);
            $quote->setCustomPrice($priceDiscount);
            $quote->setOriginalCustomPrice($priceDiscount);
            $quote->getProduct()->setIsSuperMode(true);
        } catch (\Exception $e) {
            return;
        }
    }
}
