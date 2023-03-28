<?php

namespace Tigren\CustomerGroupCatalog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Rule extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'tigren_customer_group_catalog_rule_resource_model';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('tigren_customer_group_catalog_rule', 'rule_id');
        $this->_useIsObjectNew = true;
    }
}
