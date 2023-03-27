<?php

namespace Tigren\Testimonial\Controller\Adminhtml\Question;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Tigren\Testimonial\Model\QuestionFactory;

class Delete extends Action implements HttpGetActionInterface
{
    protected $questionFactory;

    public function __construct(Context $context, QuestionFactory $questionFactory)
    {
        $this->questionFactory = $questionFactory;
        parent::__construct($context);
    }

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
