<?php

namespace Tigren\CustomerGroupCatalog\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\Rule\CollectionFactory;

class Price extends AbstractHelper
{
    protected $ruleCollection;

    public function __construct(CollectionFactory $ruleCollection, Context $context)
    {
        $this->ruleCollection = $ruleCollection;
        parent::__construct($context);
    }

    public function getRuleMatch($product)
    {
        $validateTotal = 0;
        $priority = [];
        $collection = $this->ruleCollection->create();
        $collection->addFieldToFilter('active', 1);
        if (!empty($collection)) {
            foreach ($collection as $rule) {
                /** @var \Tigren\CustomerGroupCatalog\Model\Rule $rule */
                if ($rule->getConditions()->validate($product)) {
                    $validateTotal++;
                    $priority[] = $rule->getPriority();
                    $data = $rule;
                }
                if ($validateTotal > 1) {
                    if ($rule->getPriority() == min($priority)) {
                        $data = $rule;
                    }
                }
            }
            return '';
        }
        return '';
    }
}
