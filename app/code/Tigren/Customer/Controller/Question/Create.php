<?php

namespace Tigren\Customer\Controller\Question;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\Customer\Model\Session;


/**
 *
 */
class Create extends Action
{
    /**
     * @var PageFactory
     */
    protected $_pageFactory;
    protected $customerSession;


    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Session $customerSession

    ) {
        $this->_pageFactory = $pageFactory;
        $this->customerSession=$customerSession;
        return parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface|Page
     */
    public function execute()
    {
          $customer=$this->getCustomer();

          if($this->customerSession->isLoggedIn()){
              $resutl= $this->_pageFactory->create();
          }else{
             $resutl= $this->resultRedirectFactory->create()->setPath('/');
          }
               return $resutl;
    }

    public function getCustomer(){
        return $this->customerSession->getCustomer();
    }
}
