<?php

namespace Tigren\Customer\Block;

use Magento\Framework\Phrase;
use Magento\Framework\View\Element\Template;

/**
 *
 */
class Index extends Template
{
    /**
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(Template\Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

    /**
     * @return Phrase
     */
    public function getTitle()
    {
        return __('HelloWorld!');

    }
}
