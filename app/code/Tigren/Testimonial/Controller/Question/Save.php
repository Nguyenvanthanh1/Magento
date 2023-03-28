<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License (“OSL”) v. 3.0
 */

namespace Tigren\Testimonial\Controller\Question;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Tigren\Testimonial\Helper\Image;
use Tigren\Testimonial\Model\QuestionFactory;
use Tigren\Testimonial\Model\ResourceModel\Question as ResourceQuestion;

/**
 * Class Save
 * @package Tigren\Testimonial\Controller\Question
 */
class Save extends Action implements HttpPostActionInterface
{
    /**
     * @var Image
     */
    protected $helperImage;

    /**
     * @var QuestionFactory
     */
    protected $questionFactory;

    /**
     * @var ResourceQuestion
     */
    protected $resourceQuestion;

    /**
     * @param Context $context
     * @param Image $helperImage
     * @param QuestionFactory $questionFactory
     * @param ResourceQuestion $resourceQuestion
     */
    public function __construct(
        Context $context,
        Image $helperImage,
        QuestionFactory $questionFactory,
        ResourceQuestion $resourceQuestion
    ) {
        $this->resourceQuestion = $resourceQuestion;
        $this->questionFactory = $questionFactory;
        $this->helperImage = $helperImage;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getParams();
        $dataFile = $this->getRequest()->getFiles()['image'];
        $fileName = ($dataFile && array_key_exists('name', $dataFile)) ? $dataFile['name'] : '';
        if (!empty($data)) {
            $questionModel = $this->questionFactory->create();
            if (isset($data['question_id']) && !empty($data['question_id'])) {
                $questionModel->load($data['question_id']);
            }
            $questionModel->setData($data);
            if (!isset($data['status'])) {
                $questionModel->setStatus(1);
            }
            if (!empty($fileName)) {
                $this->setFile($fileName, $questionModel);
            }
            try {
                $this->resourceQuestion->save($questionModel);
                $this->messageManager->addSuccessMessage(__('Save question successfully'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Save question failed'));
                return $this->resultRedirectFactory->create()->setPath('*/*/create');
            }
        }
        return $this->resultRedirectFactory->create()->setPath('*/*/');
    }

    /**
     * @param $fileName
     * @param $model
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function setFile($fileName, $model)
    {
        $fileUploader = $this->helperImage->uploadImage($fileName);
        if ($fileUploader) {
            $fileNameUploader = $fileUploader['file'];
            $model->setProfileImage($fileNameUploader);
        }
    }
}
