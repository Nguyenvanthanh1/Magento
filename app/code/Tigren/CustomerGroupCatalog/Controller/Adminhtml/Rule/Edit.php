<?php

namespace Tigren\CustomerGroupCatalog\Controller\Adminhtml\Rule;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Tigren\CustomerGroupCatalog\Api\RuleRepositoryInterface;
use Tigren\CustomerGroupCatalog\Controller\RegistryConstants;
use Tigren\CustomerGroupCatalog\Model\RuleFactory;
class Edit extends Rule
{
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

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        /** @var \Tigren\CustomerGroupCatalog\Model\Rule $model */

        if ($id) {
            try {
                $model = $this->ruleRepository->get($id);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Rule not exist'));
                $this->resultRedirectFactory->create()->setPath('customer_catalog/*');
                return;
            }
        } else {
            $model = $this->ruleFactory->create();
        }
        $data = $this->_session->getPageData(true);

        if (!empty($data)) {
            $model->setData($data);
        }
        $model->getConditions()->setFormName('customer_catalog_form');
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
