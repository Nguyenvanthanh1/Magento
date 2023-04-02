<?php

namespace Tigren\CustomerGroupCatalog\Controller\Adminhtml\Rule;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Registry;
use Tigren\CustomerGroupCatalog\Api\RuleRepositoryInterface;
use Tigren\CustomerGroupCatalog\Model\RuleFactory;

class Create extends Rule implements HttpGetActionInterface
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
         $this->_forward('edit');
    }
}
