<?php

namespace Tigren\CustomerGroupCatalog\Model;

use Magento\Framework\Model\AbstractModel;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\Rule as ResourceModel;

class Rule extends AbstractModel
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'tigren_customer_group_catalog_rule_model';

    /**
     * Initialize magento model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}
