<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License (“OSL”) v. 3.0
 */

namespace Tigren\CustomerGroupCatalog\Controller\Adminhtml\Rule;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Registry;
use Tigren\CustomerGroupCatalog\Api\RuleRepositoryInterface;
use Tigren\CustomerGroupCatalog\Model\RuleFactory;

/**
 * Class Create
 * @package Tigren\CustomerGroupCatalog\Controller\Adminhtml\Rule
 */
class Create extends Rule implements HttpGetActionInterface
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
        $this->_forward('edit');
    }
}
