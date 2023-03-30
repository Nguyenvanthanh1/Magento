<?php

namespace Tigren\CustomerGroupCatalog\Model;

use Magento\CatalogWidget\Model\Rule\Condition\CombineFactory;
use Magento\CatalogWidget\Model\Rule\Condition\ProductFactory;
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

class Rule extends AbstractModel implements RuleInterface
{
    protected $condCombineFactory;

    protected $condProdCombineF;
    /**
     * @var string
     */
    protected $_eventPrefix = 'tigren_customer_group_catalog_rule_model';

    public function __construct(
        CombineFactory $condCombineFactory,
        ProductFactory $condProdCombineF,
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

    public function getConditionsFieldSetId($formName = '')
    {
        return $formName . 'rule_conditions_fieldset_' . $this->getId();
    }

    public function getConditionsInstance()
    {
        return $this->condCombineFactory->create();
    }

    public function getActionsInstance()
    {
        return $this->condProdCombineF->create();
    }
    public function setRuleId($ruleId)
    {
        return $this->setData('rule_id', $ruleId);
    }

    public function getRuleId()
    {
        return $this->getData('rule_id');
    }

    public function setName($name)
    {
        return $this->setData('name', $name);
    }

    public function getName()
    {
        return $this->getData('name');
    }

    public function setActive($active)
    {
        return $this->setData('active', $active);
    }

    public function getActive()
    {
        return $this->getData('active');
    }

    public function getPriority()
    {
        return $this->getData('priority');
    }

    public function setPriority($priority)
    {
        return $this->setData('priority', $priority);
    }

    public function setStartTime($startTime)
    {
        return $this->setData('start_time', $startTime);
    }

    public function getStartTime()
    {
        return $this->getData('start_time');
    }

    public function setEndTime($endTime)
    {
        return $this->setData('end_time', $endTime);
    }

    public function getEndTime()
    {
        return $this->getData('end_time');
    }

    public function setUseRangeDate($useRangeDate)
    {
        return $this->getData('use_range_date', $useRangeDate);
    }

    public function getUseRangeDate()
    {
        return $this->getData('use_range_date');
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
