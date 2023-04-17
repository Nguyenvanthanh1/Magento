<?php

namespace Tigren\AdvancedCheckout\Controller\Index;

use Magento\Checkout\Model\SessionFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class DeleteQuote extends Action
{
    private $sessionFactory;

    public function __construct(SessionFactory $sessionFactory, Context $context)
    {
        $this->sessionFactory = $sessionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $message=[];
        $requestDeleteCart=$this->getRequest()->getParam('request');
        if($requestDeleteCart){
            $sessionCart=$this->sessionFactory->create();
            if($sessionCart->clearQuote()){
                $message['message'] ='success';
            }else{
                $message['message']='fail';
            }
        }
         $resultJson= $this->resultFactory->create(ResultFactory::TYPE_JSON);
        return $resultJson->setData($message);
    }
}
