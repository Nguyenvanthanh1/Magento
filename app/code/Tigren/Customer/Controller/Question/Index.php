<?php

namespace Tigren\Customer\Controller\Question;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * @package Class Index of Tigren\Customer\Controller\Question
 */
class Index extends Action
{
    /**
     * @var Session
     */
    protected $customerSession;
    /**
     * @var PageFactory
     */
    protected $_pageFactory;
    /**
     * @var CollectionFactory
     */


    /**
     * @param Collection $collectionFactory
     * @param Session $customerSession
     * @param Context $context
     * @param PageFactory $_pageFactory
     */
    public function __construct(

        Session $customerSession,
        Context $context,
        PageFactory $_pageFactory
    ) {
        $this->_pageFactory = $_pageFactory;
        $this->customerSession = $customerSession;
        return parent::__construct($context);
    }


    /**
     * @return ResponseInterface|ResultInterface|Page
     */
    public function execute()
   {
//       if ($this->customerSession->isLoggedIn()) {
//         $customerId = $this->customerSession->getCustomerId();
////      }
////        $result=$this->collectionFactory->create()->addFieldToFilter('author_id',$customerId);

        return $this->_pageFactory->create();
    }
}
