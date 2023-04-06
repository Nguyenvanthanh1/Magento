<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License (“OSL”) v. 3.0
 */

namespace Tigren\CustomerGroupCatalog\Model\Rule;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\Rule\Collection;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\Rule\CollectionFactory;
use Tigren\CustomerGroupCatalog\Model\RuleFactory;

/**
 * Class DataProvider
 * @package Tigren\CustomerGroupCatalog\Model\Rule
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * DataProvider component.
     * @property Collection $collection
     */
    protected $loaderData;

    /**
     * @var RuleFactory
     */
    protected $ruleFactory;

    /**
     * @param CollectionFactory $collectionRule
     * @param RuleFactory $ruleFactory
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        CollectionFactory $collectionRule,
        RuleFactory $ruleFactory,
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionRule->create();
        $this->ruleFactory = $ruleFactory;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array
     */
    public function getData()
    {
        if ($this->loaderData !== null) {
            return $this->loaderData;
        }
        $items = $this->collection->getItems();
        if (!empty($items)) {
            foreach ($items as $item) {
                $model = $this->ruleFactory->create();
                $itemData = $item->getData();
                $itemData['store_ids'] = $model->getResource()->getStoreByRuleId($item->getId());
                $itemData['customer_group_ids'] = $model->getResource()->getCustomerGroupByRuleId($item->getRuleId());
                $this->loaderData[$item->getId()] = $itemData;
            }
        }
        return $this->loaderData;
    }
}
