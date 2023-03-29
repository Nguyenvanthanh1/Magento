<?php

namespace Tigren\CustomerGroupCatalog\Controller\Adminhtml\Rule;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Tigren\CustomerGroupCatalog\Controller\RegistryConstants;
use Tigren\CustomerGroupCatalog\Model\RuleFactory;

class Edit extends Rule
{
    public function __construct(
        RuleFactory $ruleFactory,
        Registry $coreRegistry,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter,
        Context $context
    ) {
        parent::__construct($ruleFactory, $coreRegistry, $fileFactory, $dateFilter, $context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        /** @var \Tigren\CustomerGroupCatalog\Model\Rule $model */
        $model = $this->ruleFactory->create();

        //        if (!$model->getId()) {
        //            $this->messageManager->addErrorMessage(__('Rule not exist'));
        //            return $this->resultRedirectFactory->create()->setPath('*/*/');
        //        }
        $data = $this->_session->getPageData(true);

        if (!empty($data)) {
            $model->setData($data);
        }
        $model->getConditions()->setFormName('rule_condition_fieldset');
        $model->getConditions()->setJsFormObject($model->getConditionsFieldSetId($model->getConditions()->getFormName()));
        $this->coreRegistry->register(RegistryConstants::CURRENT_CATA_RULE, $model);
        $this->_initAction();

        $this->_addBreadcrumb($id ? __('Edit Rule') : __('New Rule'), $id ? __('Edit Rule') : __('New Rule'));

        $this->_view->getPage()->getConfig()->getTitle()->prepend(
            $model->getRuleId() ? $model->getName() : __('New Rule')
        );
        $this->_view->renderLayout();
    }
}
