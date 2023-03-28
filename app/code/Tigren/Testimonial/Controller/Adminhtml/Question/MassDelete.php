<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License (“OSL”) v. 3.0
 */

namespace Tigren\Testimonial\Controller\Adminhtml\Question;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Ui\Component\MassAction\Filter;
use Tigren\Testimonial\Model\Question;
use Tigren\Testimonial\Model\ResourceModel\Question\CollectionFactory;
use Tigren\Testimonial\Model\QuestionFactory;

/**
 * Class MassDelete
 * @package Tigren\Testimonial\Controller\Adminhtml\Question
 */
class MassDelete extends Action implements HttpPostActionInterface
{
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $questionCollectionFactory;

    /**
     * @var QuestionFactory
     */
    protected $questionFactory;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $questionCollectionFactory
     * @param QuestionFactory $questionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $questionCollectionFactory,
        QuestionFactory $questionFactory
    ) {
        $this->filter = $filter;
        $this->questionCollectionFactory = $questionCollectionFactory;
        $this->questionFactory = $questionFactory;
        parent::__construct($context);
    }

    /**
     * @return Redirect|ResultInterface
     */
    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->questionCollectionFactory->create());
            $totalCount = 0;
            foreach ($collection as $item) {
                /** @var Question $item */
                $data = $this->questionFactory->create()->load($item->getId());
                $data->delete();
                $totalCount++;
            }
            $this->messageManager->addSuccess(__('A total of %1 question(s) have been deleted.', $totalCount));
        } catch (Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        return $this->resultRedirectFactory->create()->setPath('*/*/');
    }
}
