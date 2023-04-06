<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License (“OSL”) v. 3.0
 */

namespace Tigren\CustomerGroupCatalog\Model\ResourceModel\Rule;

use Magento\Rule\Model\ResourceModel\Rule\Collection\AbstractCollection;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\Rule as ResourceModel;
use Tigren\CustomerGroupCatalog\Model\Rule as Model;

/**
 * Class Collection
 * @package Tigren\CustomerGroupCatalog\Model\ResourceModel\Rule
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'tigren_customer_group_catalog_rule_collection';

    /**
     * @var string
     */
    protected $_idFieldName = "rule_id";

    /**
     * Initialize collection model.
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
