<?php

namespace Tigren\CustomerGroupCatalog\Block;

use Magento\Framework\View\Element\Template;

class Price extends Template
{
    public function __construct(Template\Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

}
