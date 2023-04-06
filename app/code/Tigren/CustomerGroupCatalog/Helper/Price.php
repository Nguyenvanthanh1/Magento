<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License (“OSL”) v. 3.0
 */

namespace Tigren\CustomerGroupCatalog\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\Rule\CollectionFactory;
use Tigren\CustomerGroupCatalog\Model\RuleFactory;

/**
 * Class Price
 * @package Tigren\CustomerGroupCatalog\Helper
 */
class Price extends AbstractHelper
{
    /**
     * @var CollectionFactory
     */
    protected $ruleCollection;
    /**
     * @var
     */
    protected $ruleFactory;
    /**
     * @var
     */
    protected $cacheTypeList;
    /**
     * @var
     */
    protected $cacheFrontendPool;

    /**
     * @param RuleFactory $ruleFactory
     * @param CollectionFactory $ruleCollection
     * @param Context $context
     */
    public function __construct(RuleFactory $ruleFactory, CollectionFactory $ruleCollection, Context $context)
    {
        $this->ruleCollection = $ruleCollection;
        parent::__construct($context);
    }

    /**
     * @param $product
     * @return string|\Tigren\CustomerGroupCatalog\Model\Rule
     */
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
