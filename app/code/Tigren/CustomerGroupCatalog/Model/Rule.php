<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License (“OSL”) v. 3.0
 */

namespace Tigren\CustomerGroupCatalog\Model;

use Magento\CatalogRule\Model\Rule\Action\CollectionFactory;
use Magento\CatalogRule\Model\Rule\Condition\CombineFactory;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Rule\Model\AbstractModel;
use Tigren\CustomerGroupCatalog\Api\Data\RuleInterface;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\Rule as ResourceModel;

/**
 * Class Rule
 * @package Tigren\CustomerGroupCatalog\Model
 */
class Rule extends AbstractModel implements RuleInterface
{
    /**
     * @var CombineFactory
     */
    protected $condCombineFactory;

    /**
     * @var CollectionFactory
     */
    protected $condProdCombineF;
    /**
     * @var string
     */
    protected $_eventPrefix = 'tigren_customer_group_catalog_rule_model';

    /**
     * @param CombineFactory $condCombineFactory
     * @param CollectionFactory $condProdCombineF
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param TimezoneInterface $localeDate
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     * @param ExtensionAttributesFactory|null $extensionFactory
     * @param AttributeValueFactory|null $customAttributeFactory
     * @param Json|null $serializer
     */
    public function __construct(
        CombineFactory $condCombineFactory,
        CollectionFactory $condProdCombineF,
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        TimezoneInterface $localeDate,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = [],
        ExtensionAttributesFactory $extensionFactory = null,
        AttributeValueFactory $customAttributeFactory = null,
        Json $serializer = null
    ) {
        $this->condCombineFactory = $condCombineFactory;
        $this->condProdCombineF = $condProdCombineF;
        parent::__construct($context, $registry, $formFactory, $localeDate, $resource, $resourceCollection, $data,
            $extensionFactory, $customAttributeFactory, $serializer);
    }

    /**
     * @param $formName
     * @return string
     */
    public function getConditionsFieldSetId($formName = '')
    {
        return $formName . 'rule_conditions_fieldset_' . $this->getId();
    }

    /**
     * @return \Magento\CatalogRule\Model\Rule\Condition\Combine|\Magento\Rule\Model\Condition\Combine
     */
    public function getConditionsInstance()
    {
        return $this->condCombineFactory->create();
    }

    /**
     * @return \Magento\CatalogRule\Model\Rule\Action\Collection|\Magento\Rule\Model\Action\Collection
     */
    public function getActionsInstance()
    {
        return $this->condProdCombineF->create();
    }

    /**
     * @param $dataObject
     * @return array|string[]|true
     * @throws \Exception
     */
    public function validateData($dataObject)
    {
        $result = [];
        $fromDate = $toDate = null;

        if ($dataObject->hasStartTime() && $dataObject->hasEndTime()) {
            $fromDate = $dataObject->getStartTime();
            $toDate = $dataObject->getEndTime();
        }

        if ($fromDate && $toDate) {
            $fromDate = new \DateTime($fromDate);
            $toDate = new \DateTime($toDate);

            if ($fromDate > $toDate) {
                $result[] = __('End Date must follow Start Date.');
            }
        }

        if ($dataObject->hasStoreIds()) {
            $storeIds = $dataObject->getStoreIds();
            if (empty($storeIds)) {
                $result[] = __('Please specify a website.');
            }
        }
        if ($dataObject->hasCustomerGroupIds()) {
            $customerGroupIds = $dataObject->getCustomerGroupIds();
            if (empty($customerGroupIds)) {
                $result[] = __('Please specify Customer Groups.');
            }
        }

        return !empty($result) ? $result : true;
    }

    /**
     * @return mixed|null
     */
    public function getStartTime()
    {
        return $this->getData('start_time');
    }

    /**
     * @return mixed|null
     */
    public function getEndTime()
    {
        return $this->getData('end_time');
    }

    /**
     * @return mixed|null
     */
    public function getStoreIds()
    {
        if (!$this->hasStoreIds()) {
            $storeIds = $this->getResource()->getStoreIds($this->getId());
            $this->setData('store_ids', $storeIds);
        }
        return $this->getData('store_ids');
    }

    /**
     * @return mixed|null
     */
    public function getCustomerGroupIds()
    {
        if (!$this->hasCustomerGroupIds()) {
            $customerGroupIds = $this->getResource()->getCustomerGroupIds($this->getId());
            $this->setData('customer_group_ids', $customerGroupIds);
        }
        return $this->getData('customer_group_ids');
    }

    /**
     * @param $ruleId
     * @return mixed|Rule
     */
    public function setRuleId($ruleId)
    {
        return $this->setData('rule_id', $ruleId);
    }

    /**
     * @return mixed|null
     */
    public function getRuleId()
    {
        return $this->getData('rule_id');
    }

    /**
     * @param $name
     * @return mixed|Rule
     */
    public function setName($name)
    {
        return $this->setData('name', $name);
    }

    /**
     * @return mixed|null
     */
    public function getName()
    {
        return $this->getData('name');
    }

    /**
     * @param $active
     * @return mixed|Rule
     */
    public function setActive($active)
    {
        return $this->setData('active', $active);
    }

    /**
     * @return mixed|null
     */
    public function getActive()
    {
        return $this->getData('active');
    }

    /**
     * @return mixed|null
     */
    public function getPriority()
    {
        return $this->getData('priority');
    }

    /**
     * @param $priority
     * @return mixed|Rule
     */
    public function setPriority($priority)
    {
        return $this->setData('priority', $priority);
    }

    /**
     * @param $startTime
     * @return mixed|Rule
     */
    public function setStartTime($startTime)
    {
        return $this->setData('start_time', $startTime);
    }

    /**
     * @param $endTime
     * @return mixed|Rule
     */
    public function setEndTime($endTime)
    {
        return $this->setData('end_time', $endTime);
    }

    /**
     * @param $useRangeDate
     * @return mixed|null
     */
    public function setUseRangeDate($useRangeDate)
    {
        return $this->getData('use_range_date', $useRangeDate);
    }

    /**
     * @return mixed|null
     */
    public function getUseRangeDate()
    {
        return $this->getData('use_range_date');
    }

    /**
     * @param $discountAmount
     * @return mixed|null
     */
    public function setDiscountAmount($discountAmount)
    {
        return $this->getData('discount_amount', $discountAmount);
    }

    /**
     * @return mixed|null
     */
    public function getDiscountAmount()
    {
        return $this->getData('discount_amount');
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
