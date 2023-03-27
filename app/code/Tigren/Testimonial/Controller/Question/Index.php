<?php

namespace Tigren\Testimonial\Controller\Question;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NotFoundException;

class Index extends Action implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    /**
     * Execute action based on request and return result
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        return $resultPage;
    }
}
