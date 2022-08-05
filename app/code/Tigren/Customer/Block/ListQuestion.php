<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\Customer\Block;

use Magento\Framework\Phrase;
use Magento\Framework\View\Element\Template;
use Tigren\Customer\Model\ResourceModel\Post\CollectionFactory;
use Magento\Customer\Model\Session;

/**
 *
 */
class ListQuestion extends Template
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;
    protected $customerSession;

    /**
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(Template\Context $context,
        array $data = [],
        CollectionFactory $collectionFactory,
        Session $customerSession
    )
    {
        $this->collectionFactory = $collectionFactory;
        $this->customerSession=$customerSession;
        parent::__construct($context, $data);
    }

    /**
     * @return Phrase
     */

    public function getQuestion()
    {
        if($this->customerSession->isLoggedIn()){
            $author=$this->customerSession->getCustomerId();
        }
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('author_id',$author);
        echo $collection->getSelect()->__toString();

        return $collection;

    }

}
