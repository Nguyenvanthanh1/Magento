<?php

namespace Tigren\Testimonial\Controller\Adminhtml\Question;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Tigren\Testimonial\Model\QuestionFactory;
use Tigren\Testimonial\Model\ResourceModel\Question;

class Save extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    public const ADMIN_RESOURCE = 'Tigren_Testimonial::manage';

    protected $questionFactory;

    protected $resourceQuestion;

    public function __construct(Context $context, QuestionFactory $questionFactory, Question $resourceQuestion)
    {
        $this->questionFactory = $questionFactory;
        $this->resourceQuestion = $resourceQuestion;
        parent::__construct($context);
    }

    /**
     * Execute action based on request and return result
     *
     * @return ResultInterface|ResponseInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getParams();
        $dataImage = array_key_exists('profile_image', $data) ? $data['profile_image'] : '';

        if (!empty($data)) {
            $questionModel = $this->questionFactory->create();
            if (isset($data['question_id']) && !empty($data['question_id'])) {
                $questionModel->load($data['question_id']);
            }
            $questionModel->setData($data);
            if ($dataImage) {
                $questionModel->setProfileImage($dataImage[0]['file']);
            }
            try {
                $this->resourceQuestion->save($questionModel);
                $this->messageManager->addSuccessMessage(__('The question saved'));
            } catch (Exception $e) {
                $this->messageManager->addErrorMessage(__('Save question failed'));
                $this->resultRedirectFactory->create()->setPath('*/*/create');
            }
        }
        return $this->resultRedirectFactory->create()->setPath('*/*/');
    }
}
