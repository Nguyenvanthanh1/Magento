<?php

namespace Tigren\AdvancedCheckout\Block;

use Magento\Framework\View\Element\Template;

class Modal extends Template
{
public function __construct(Template\Context $context, array $data = [])
{
    parent::__construct($context, $data);
}
}
