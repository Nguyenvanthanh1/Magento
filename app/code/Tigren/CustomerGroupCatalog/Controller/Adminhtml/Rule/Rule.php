<?php

namespace Tigren\CustomerGroupCatalog\Controller\Adminhtml\Rule;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Tigren\CustomerGroupCatalog\Api\RuleRepositoryInterface;
use Tigren\CustomerGroupCatalog\Controller\RegistryConstants;
use Tigren\CustomerGroupCatalog\Model\RuleFactory;

abstract class Rule extends Action
{

    protected $ruleFactory;

    protected $coreRegistry;

    protected $fileFactory;

    protected $dateFilter;

    protected $ruleRepository;

    public function __construct(
        RuleFactory $ruleFactory,
        Registry $coreRegistry,
        RuleRepositoryInterface $ruleRepository,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter,
        Context $context
    ) {
        $this->ruleFactory = $ruleFactory;
        $this->ruleRepository = $ruleRepository;
        $this->fileFactory = $fileFactory;
        $this->dateFilter = $dateFilter;
        $this->coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    public function _initRule()
    {
        $rule = $this->ruleFactory->create();
        $this->coreRegistry->register(RegistryConstants::CURRENT_CATA_RULE, $rule);
        $id = $this->getRequest()->getParam('id');

        if (!$id && !empty($this->getRequest()->getParam('rule_id'))) {
            $id = $this->getRequest()->getParam('rule_id');
            $rule->load($id);
        }
        if (!empty($id)) {
            $this->coreRegistry->register(RegistryConstants::CURRENT_CATA_RULE, $rule->load($id));
        }
    }

    public function _initAction()
    {
        $this->_view->loadLayout();
        $this->_setActiveMenu(
            'Tigren_CustomerGroupCatalog::listing'
        )->_addBreadcrumb(
            __('Promotions'),
            __('Promotions')
        );
        return $this;
    }
}
