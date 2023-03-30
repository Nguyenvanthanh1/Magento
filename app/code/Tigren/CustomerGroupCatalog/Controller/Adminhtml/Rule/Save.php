<?php

namespace Tigren\CustomerGroupCatalog\Controller\Adminhtml\Rule;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Registry;
use Tigren\CustomerGroupCatalog\Model\RuleFactory;

class Save extends \Tigren\CustomerGroupCatalog\Controller\Adminhtml\Rule\Rule implements HttpPostActionInterface
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
        $data = $this->getRequest()->getParams();

        if (!empty($data)) {
            $modelRule = $this->ruleFactory->create();
            $dataField = $this->validateData($data);
            $modelRule->setData($data);
            $modelRule->save();
        }
    }
}
