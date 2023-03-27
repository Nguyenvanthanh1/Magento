<?php

namespace Tigren\Testimonial\Block;

use Magento\Framework\View\Element\Template;
use Tigren\Testimonial\Model\ResourceModel\Question\CollectionFactory;

class Question extends Template
{
    protected $questionCollection;

    public function __construct(CollectionFactory $questionCollection, Template\Context $context, array $data = [])
    {
        $this->questionCollection = $questionCollection;
        parent::__construct($context, $data);
    }

    public function getDataQuestion()
    {
        $data = $this->questionCollection->create();

        return $data;
    }
}
