<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\Customer\Controller\Question;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Tigren\Customer\Model\PostFactory;

/**
 *
 */
class Confirm extends Action
{
    /**
     * @var PageFactory
     */
    protected $_pageFactory;
    /**
     * @var PostFatory
     */
    protected $postFactory;
    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        PostFactory $postFactory,
        Session $customerSession
    ) {
        $this->_pageFactory = $pageFactory;
        $this->postFactory = $postFactory;
        $this->customerSession = $customerSession;
        return parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface|Page
     */
    public function execute()
    {
        $data = $this->getRequest()->getParams();
        $customerId = '';
        if ($this->customerSession->isLoggedIn()) {
            $customerId = $this->customerSession->getCustomerId();

        }
        if (isset($data)) {
            $newData = [
                'title' => $data['title'],
                'content' => $data['content'],
                'author_id' => $customerId
            ];
            $post = $this->postFactory->create();
            $post->addData($newData);
            $post->save();
        }
        return $this->resultRedirectFactory->create()->setPath('tigren_customer/question/');
    }

    /**
     * @return \Magento\Customer\Model\Customer
     */
    public function getCustomer()
    {
        return $this->customerSession->getCustomer();
    }
}
