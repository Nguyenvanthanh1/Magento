<?php

namespace Tigren\CustomerGroupCatalog\Model\ResourceModel\Rule;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\Rule as ResourceModel;
use Tigren\CustomerGroupCatalog\Model\Rule as Model;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'tigren_customer_group_catalog_rule_collection';

    /**
     * Initialize collection model.
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
