<?php

namespace Tigren\Testimonial\Controller\Adminhtml\Question;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NotFoundException;
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
     * @throws NotFoundException
     */
    public function execute()
    {
        $data = $this->getRequest()->getParam('general');
        $dataImage = array_key_exists('image', $data) ? $data['image']  : '';

        if (!empty($data)) {
            $questionModel = $this->questionFactory->create();
            $questionModel->setData($data);
            if ($dataImage) {
                $questionModel->setProfileImage($dataImage[0]['file']);
            }
            try {
                $this->resourceQuestion->save($questionModel);
            } catch (Exception $e) {
                $this->messageManager->addErrorMessage(__('Save question failed'));
                $this->resultRedirectFactory->create()->setUrl('*/*/create');
            }
        }
        return $this->resultRedirectFactory->create()->setUrl('*/*/');
    }
}
