<?php

namespace Tigren\CustomerGroupCatalog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Rule extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'tigren_customer_group_catalog_rule_resource_model';

    protected function _afterSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $object->getId();
        $this->addGroupData($object);
        $this->addStoreData($object);
        return parent::_afterSave($object);
    }

    public function addGroupData($object)
    {
        $_prefixGroup = '_group';
        $tableGroup = $this->getMainTable() . $_prefixGroup;
        if (isset($object['customer_group_ids']) && is_array($object['customer_group_ids'])) {
            foreach ($object['customer_group_ids'] as $groupId) {
                $this->getConnection()->insert($tableGroup,
                    ['customer_group_id' => $groupId, 'rule_id' => $object->getId()]);
            }
        }
    }

    public function addStoreData($object)
    {
        $_prefixStore = '_store';
        $tableStore = $this->getMainTable() . $_prefixStore;
        if (isset($object['store_ids']) && is_array($object['store_ids'])) {
        foreach ($object['store_ids'] as $storeId) {
            $this->getConnection()->insert($tableStore, ['store_id' => $storeId, 'rule_id' => $object->getId()]);
        }
    }
    }

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('tigren_customer_group_catalog_rule', 'rule_id');
        $this->_useIsObjectNew = true;
    }
}
