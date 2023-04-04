<?php

namespace Tigren\CustomerGroupCatalog\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Rule extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'tigren_customer_group_catalog_rule_resource_model';

    public function getStoreByRuleId($ruleId)
    {
        $result = $this->getConnection()->select()->from(['main_table' => $this->getMainTable()])->join(['st' => $this->getTable($this->getMainTable() . '_store')],
            'main_table.rule_id=st.rule_id')->where('st.rule_id=?', $ruleId);
        return $this->filterData($this->getConnection()->fetchAll($result));

    }

    public function filterData($data)
    {
        $datas = [];
        foreach ($data as $item) {
            if (array_key_exists('store_id', $item)) {
                $datas[] = $item['store_id'];
            }
            if (array_key_exists('customer_group_id', $item)) {
                $datas[] = $item['customer_group_id'];
            }
        }
        return $datas;
    }

    public function getCustomerGroupByRuleId($ruleId)
    {
        $result = $this->getConnection()->select()->from(['main_table' => $this->getMainTable()])->join(['cg' => $this->getTable($this->getMainTable() . '_group')],
            'main_table.rule_id=cg.rule_id')->where('cg.rule_id=?', $ruleId);
        return $this->filterData($this->getConnection()->fetchAll($result));

    }

    protected function _afterSave(AbstractModel $object)
    {
        $this->addGroupData($object);
        $this->addStoreData($object);
        return parent::_afterSave($object);
    }

    public function addGroupData($object)
    {
        $_prefixGroup = '_group';
        $tableGroup = $this->getMainTable() . $_prefixGroup;
        $selectGroup = $this->getConnection()->select()->from($tableGroup)->where('rule_id=?', $object->getRuleId());
        $checkRule = $this->getConnection()->fetchAll($selectGroup);
        if (!empty($checkRule)) {
            foreach ($checkRule as $rule) {
                if (isset($object['customer_group_ids']) && is_array($object['customer_group_ids'])) {
                    foreach ($object['customer_group_ids'] as $groupId) {
                        if ($rule['customer_group_id'] === $groupId) {
                            $this->getConnection()->insertOnDuplicate($tableGroup,
                                ['customer_group_id' => $groupId, 'rule_id' => $object->getId()]);
                        }
                        if ($rule['rule_id'] === $object['rule_id'] && $rule['customer_group_id'] !== $groupId) {
                            $this->getConnection()->delete($tableGroup, ['customer_group_id' => $rule['customer_group_id']]);
                        }
                            $this->getConnection()->insertOnDuplicate($tableGroup,
                                ['customer_group_id' => $groupId, 'rule_id' => $object->getId()]);
                    }
                }
            }
        }
    }

    public function addStoreData($object)
    {
        $_prefixStore = '_store';
        $tableStore = $this->getMainTable() . $_prefixStore;
        $selectStore = $this->getConnection()->select()->from($tableStore)->where('rule_id=?', $object->getRuleId());
        $checkRule = $this->getConnection()->fetchAll($selectStore);
        if (!empty($checkRule)) {
            foreach ($checkRule as $rule) {
                if (isset($object['store_ids']) && is_array($object['store_ids'])) {
                    foreach ($object['store_ids'] as $storeId) {
                        if ($rule['store_id'] === $storeId) {
                            $this->getConnection()->insertOnDuplicate($tableStore,
                                ['store_id' => $storeId, 'rule_id' => $object->getId()]);
                        }
                        if ($rule['rule_id'] === $object['rule_id'] && $rule['store_id'] !== $storeId) {
                            $this->getConnection()->delete($tableStore, ['store_id' => $storeId]);
                        } else {
                            $this->getConnection()->insertOnDuplicate($tableStore,
                                ['store_id' => $storeId, 'rule_id' => $object->getId()]);
                        }
                    }
                }
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
