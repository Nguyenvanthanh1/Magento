<?php

namespace Tigren\CustomerGroupCatalog\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\Rule\CollectionFactory;
use Tigren\CustomerGroupCatalog\Model\RuleFactory;

class Price extends AbstractHelper
{
    protected $ruleCollection;
    protected $ruleFactory;
    protected $cacheTypeList;
    protected $cacheFrontendPool;
    public function __construct(RuleFactory $ruleFactory, CollectionFactory $ruleCollection, Context $context)
    {
        $this->ruleCollection = $ruleCollection;
        parent::__construct($context);
    }

    public function getRuleMatch($product)
    {
        $collection = $this->ruleCollection->create();
        $collection->addFieldToFilter('active', 1);
        $validateCount = 0;
        $priority = [];
        $ruleMath = '';
        if (!empty($collection)) {
            foreach ($collection as $rule) {
                /** @var \Tigren\CustomerGroupCatalog\Model\Rule $rule */
                $validate = $rule->getConditions()->validate($product);
                if ($validate === true) {
                    $validateCount++;
                    $priority[] = $rule->getPriority();
                }
                if ($validate && $validateCount === 1) {
                    $ruleMath = $rule;
                } else {
                    if ($validate && $validateCount > 1 && count($priority) && $rule->getPriority() === min($priority)) {
                        $ruleMath = $rule;
                    }
                }
            }
        }
        return $validateCount > 1 ? $ruleMath : '';
    }
}
