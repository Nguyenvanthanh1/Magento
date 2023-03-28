<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License (“OSL”) v. 3.0
 */

namespace Tigren\Testimonial\Controller\Adminhtml\Question;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Tigren\Testimonial\Model\QuestionFactory;

/**
 * Class Delete
 * @package Tigren\Testimonial\Controller\Adminhtml\Question
 */
class Delete extends Action implements HttpGetActionInterface
{
    /**
     * @var QuestionFactory
     */
    protected $questionFactory;

    /**
     * @param Context $context
     * @param QuestionFactory $questionFactory
     */
    public function __construct(Context $context, QuestionFactory $questionFactory)
    {
        $this->questionFactory = $questionFactory;
        parent::__construct($context);
    }

    /**
     * @return Redirect
     */
    public function execute()
    {
        $questionId = $this->getRequest()->getParam('id');

        if (isset($questionId) && !empty($questionId)) {
            try {
                $modelQuestion = $this->questionFactory->create();
                $modelQuestion->load($questionId);
                $modelQuestion->delete();
                $this->messageManager->addSuccessMessage(__('Delete record question have id is %1 successfully.',
                    $questionId));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }
        return $this->resultRedirectFactory->create()->setPath('*/*/');
    }
}
