<?php

namespace Tigren\CustomerGroupCatalog\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Rule
 * @package Tigren\CustomerGroupCatalog\Model\ResourceModel
 */
class Rule extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'tigren_customer_group_catalog_rule_resource_model';

    /**
     * @param $ruleId
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getStoreByRuleId($ruleId)
    {
        $result = $this->getConnection()->select()->from(['main_table' => $this->getMainTable()])->join(
            ['st' => $this->getTable($this->getMainTable() . '_store')],
            'main_table.rule_id=st.rule_id'
        )->where('st.rule_id=?', $ruleId);
        return $this->filterData($this->getConnection()->fetchAll($result));
    }

    /**
     * @param $data
     * @return array
     */
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

    /**
     * @param $ruleId
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCustomerGroupByRuleId($ruleId)
    {
        $result = $this->getConnection()->select()->from(['main_table' => $this->getMainTable()])->join(
            ['cg' => $this->getTable($this->getMainTable() . '_group')],
            'main_table.rule_id=cg.rule_id'
        )->where('cg.rule_id=?', $ruleId);
        return $this->filterData($this->getConnection()->fetchAll($result));
    }

    /**
     * @param AbstractModel $object
     * @return Rule
     */
    protected function _afterSave(AbstractModel $object)
    {
        $this->addGroupData($object);
        $this->addStoreData($object);
        return parent::_afterSave($object);
    }

    /**
     * @param $object
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function addGroupData($object)
    {
        $_prefixGroup = '_group';
        $tableGroup = $this->getMainTable() . $_prefixGroup;
        $connection = $this->getConnection();
        $selectGroup = $connection->select()->from($tableGroup)->where('rule_id=?', $object->getRuleId());
        $checkRule = $connection->fetchAll($selectGroup);
        if (!empty($checkRule) && is_array($checkRule)) {
            foreach ($checkRule as $rule) {
                if (!in_array(
                    $rule['customer_group_id'],
                    $object['customer_group_ids']
                ) && isset($object['customer_group_ids']) && is_array($object['customer_group_ids']) && !empty($object['customer_group_ids'])) {
                    $connection->delete(
                        $tableGroup,
                        ['customer_group_id=?' => $rule['customer_group_id'], 'rule_id=?' => $object['rule_id']]
                    );
                }
                if (isset($object['customer_group_ids']) && !empty($object['customer_group_ids']) && is_array($object['customer_group_ids'])) {
                    foreach ($object['customer_group_ids'] as $groupId) {
                        $this->getConnection()->insertOnDuplicate(
                            $tableGroup,
                            ['customer_group_id' => $groupId, 'rule_id' => $object->getId()]
                        );
                    }
                }
            }
        } else {
            if (isset($object['customer_group_ids']) && !empty($object['customer_group_ids']) && is_array($object['customer_group_ids'])) {
                foreach ($object['customer_group_ids'] as $groupId) {
                    $this->getConnection()->insert(
                        $tableGroup,
                        ['customer_group_id' => $groupId, 'rule_id' => $object->getId()]
                    );
                }
            }
        }
    }

    /**
     * @param $object
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function addStoreData($object)
    {
        $_prefixStore = '_store';
        $tableStore = $this->getMainTable() . $_prefixStore;
        $selectStore = $this->getConnection()->select()->from($tableStore)->where('rule_id=?', $object->getRuleId());
        $checkRule = $this->getConnection()->fetchAll($selectStore);

        if (!empty($checkRule) && is_array($checkRule)) {
            foreach ($checkRule as $rule) {
                if (!in_array(
                    $rule['store_id'],
                    $object['store_ids']
                ) && isset($object['store_ids']) && is_array($object['store_ids']) && !empty($object['store_ids'])) {
                    $this->getConnection()->delete(
                        $tableStore,
                        ['store_id=?' => $rule['store_id'], 'rule_id=?' => $object->getRuleId()]
                    );
                }
            }
            if (isset($object['store_ids']) && is_array($object['store_ids']) && !empty($object['store_ids'])) {
                foreach ($object['store_ids'] as $storeId) {
                    $this->getConnection()->insertOnDuplicate(
                        $tableStore,
                        ['store_id' => $storeId, 'rule_id' => $object->getId()]
                    );
                }
            }
        } else {
            if (isset($object['store_ids']) && !empty($object['store_ids']) && is_array($object['store_ids'])) {
                foreach ($object['store_ids'] as $storeId) {
                    $this->getConnection()->insert(
                        $tableStore,
                        ['store_id' => $storeId, 'rule_id' => $object->getId()]
                    );
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
