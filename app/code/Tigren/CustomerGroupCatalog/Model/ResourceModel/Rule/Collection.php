<?php

namespace Tigren\CustomerGroupCatalog\Model\ResourceModel\Rule;

use Magento\Rule\Model\ResourceModel\Rule\Collection\AbstractCollection;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\Rule as ResourceModel;
use Tigren\CustomerGroupCatalog\Model\Rule as Model;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'tigren_customer_group_catalog_rule_collection';

    protected $_idFieldName= "rule_id";
    /**
     * Initialize collection model.
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
