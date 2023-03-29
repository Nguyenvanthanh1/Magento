<?php

namespace Tigren\CustomerGroupCatalog\Model;

use Magento\Rule\Model\AbstractModel;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\Rule as ResourceModel;

class Rule extends AbstractModel
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'tigren_customer_group_catalog_rule_model';

    public function getConditionsFieldSetId($formName = '')
    {
        return $formName . 'rule_conditions_fieldset_' . $this->getId();
    }

    public function getConditionsInstance()
    {
        return [];
    }

    public function getActionsInstance()
    {
        return [];
    }

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
