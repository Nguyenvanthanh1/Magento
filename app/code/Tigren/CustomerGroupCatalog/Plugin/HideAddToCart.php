<?php

namespace Tigren\CustomerGroupCatalog\Plugin;

use Magento\Framework\App\Http\Context;

class HideAddToCart
{
    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    public function afterIsSalable(\Magento\Catalog\Model\Product $subject, $result)
    {
        if (!$this->context->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH)) {
            return false;
        }
        return $result;
    }
}
