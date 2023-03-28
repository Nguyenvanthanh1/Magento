<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License (“OSL”) v. 3.0
 */

namespace Tigren\Testimonial\Block;

use Magento\Framework\View\Element\Template;
use Tigren\Testimonial\Model\ResourceModel\Question\CollectionFactory;

/**
 * Class Question
 * @package Tigren\Testimonial\Block
 */
class Question extends Template
{
    /**
     * @var CollectionFactory
     */
    protected $questionCollection;

    /**
     * @param CollectionFactory $questionCollection
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(CollectionFactory $questionCollection, Template\Context $context, array $data = [])
    {
        $this->questionCollection = $questionCollection;
        parent::__construct($context, $data);
    }

    /**
     * @return \Tigren\Testimonial\Model\ResourceModel\Question\Collection
     */
    public function getDataQuestion()
    {
        $data = $this->questionCollection->create();
        $data->addFieldToFilter('status', 1);
        $data->getItems();
        return $data;
    }
}
