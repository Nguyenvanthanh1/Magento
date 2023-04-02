<?php

namespace Tigren\CustomerGroupCatalog\Controller\Adminhtml\Rule;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Registry;
use Tigren\CustomerGroupCatalog\Api\RuleRepositoryInterface;
use Tigren\CustomerGroupCatalog\Model\RuleFactory;

class Save extends \Tigren\CustomerGroupCatalog\Controller\Adminhtml\Rule\Rule implements HttpPostActionInterface
{
    protected $dataPersistor;

    public function __construct(
        DataPersistorInterface $dataPersistor,
        RuleFactory $ruleFactory,
        Registry $coreRegistry,
        RuleRepositoryInterface $ruleRepository,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter,
        Context $context
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($ruleFactory, $coreRegistry, $ruleRepository, $fileFactory, $dateFilter, $context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getParams();

        if (!empty($data)) {
            if (isset($data['rule']['conditions'])) {
                $data['conditions'] = $data['rule']['conditions'];
                unset($data['rule']);
            }
            $modelRule = $this->ruleFactory->create();
            try {
                if ($this->getRequest()->getParam('rule_id')) {
                    $modelRule = $this->ruleRepository->get($this->getRequest()->getParam('rule_id'));
                }
                $validateResult = $modelRule->validateData(new DataObject($data));
                if ($validateResult !== true) {
                    foreach ($validateResult as $errorMessage) {
                        $this->messageManager->addErrorMessage($errorMessage);
                    }

                    $this->_getSession()->setPageData($data);
                    $this->dataPersistor->set('tigren_customer_group_catalog_rule', $data);

                    return $this->resultRedirectFactory->create()->setPath(
                        'customer_catalog/*/edit',
                        ['id' => $modelRule->getId()]
                    );
                }
                $modelRule->loadPost($data);
                $this->_getSession()->setPageData($data);
                $this->dataPersistor->set('tigren_customer_group_catalog_rule', $data);
                $this->ruleRepository->save($modelRule);
                $this->messageManager->addSuccessMessage(__('The rule is saved.'));
                $this->_getSession()->setPageData(false);
                $this->dataPersistor->clear('tigren_customer_group_catalog_rule');
                if ($this->getRequest()->getParam('back')) {
                    return $this->resultRedirectFactory->create()->setPath(
                        'customer_catalog/*/edit',
                        ['id' => $modelRule->getId()]
                    );
                }
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $this->getRequest()->getParam('id') ?
                    $this->resultRedirectFactory->create()->setPath('customer_catalog/*/edit',
                        ['id' => $this->getRequest()->getParam('id')]) :
                    $this->resultRedirectFactory->create()->setPath('*/*/create');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(
                    __('Something went wrong while saving the rule data. Please review the error log.')
                );
                $this->_getSession()->setPageData($data);
                $this->dataPersistor->set('tigren_customer_group_catalog_rule', $data);

                return $this->resultRedirectFactory->create()->setPath(
                    'customer_catalog/*/edit',
                    ['id' => $this->getRequest()->getParam('rule_id')]
                );
            }
        }
        return $this->resultRedirectFactory->create()->setPath('*/*/');
    }
}
