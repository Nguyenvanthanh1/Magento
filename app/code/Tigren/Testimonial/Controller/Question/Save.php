<?php

namespace Tigren\Testimonial\Controller\Question;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;

class Save extends Action implements HttpPostActionInterface
{

    public function execute()
    {
     $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
     $logger = new \Zend_Log();
     $logger->addWriter($writer);
     $logger->info(print_r(''), true);
    }
}
