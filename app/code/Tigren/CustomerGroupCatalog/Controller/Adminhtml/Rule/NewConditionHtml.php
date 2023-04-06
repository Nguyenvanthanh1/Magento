<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License (“OSL”) v. 3.0
 */

namespace Tigren\CustomerGroupCatalog\Controller\Adminhtml\Rule;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Registry;
use Magento\Rule\Model\Condition\AbstractCondition;
use Magento\Rule\Model\Condition\ConditionInterface;
use Tigren\CustomerGroupCatalog\Api\RuleRepositoryInterface;
use Tigren\CustomerGroupCatalog\Model\RuleFactory;

/**
 * Class NewConditionHtml
 * @package Tigren\CustomerGroupCatalog\Controller\Adminhtml\Rule
 */
class NewConditionHtml extends \Tigren\CustomerGroupCatalog\Controller\Adminhtml\Rule\Rule implements HttpPostActionInterface
{
    /**
     * @param RuleFactory $ruleFactory
     * @param Registry $coreRegistry
     * @param RuleRepositoryInterface $ruleRepository
     * @param \Magento\Framework\App\Response\Http\FileFactory $fileFactory
     * @param \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter
     * @param Context $context
     */
    public function __construct(
        RuleFactory $ruleFactory,
        Registry $coreRegistry,
        RuleRepositoryInterface $ruleRepository,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter,
        Context $context
    ) {
        parent::__construct($ruleFactory, $coreRegistry, $ruleRepository, $fileFactory, $dateFilter, $context);
    }

    /**
     * @return void
     */
    public function execute()
    {
        $objectId = $this->getRequest()->getParam('id');
        $formNamespace = $this->getRequest()->getParam('form_namespace');
        $types = explode(
            '|',
            str_replace('-', '/', $this->getRequest()->getParam('type', ''))
        );
        $objectType = $types[0];
        $reponseBody = '';

        if (class_exists($objectType) && !in_array(ConditionInterface::class, class_implements($objectType))) {
            $this->getResponse()->setBody($reponseBody);
            return;
        }

        $conditionModel = $this->_objectManager->create($objectType)
            ->setId($objectId)
            ->setType($objectType)
            ->setRule($this->ruleFactory->create())
            ->setPrefix('conditions');

        if (!empty($types[1])) {
            $conditionModel->setAttribute($types[1]);
        }

        if ($conditionModel instanceof AbstractCondition) {
            $conditionModel->setJsFormObject($this->getRequest()->getParam('form'));
            $conditionModel->setFormName($formNamespace);
            $reponseBody = $conditionModel->asHtmlRecursive();
        }

        $this->getResponse()->setBody($reponseBody);
    }
}
