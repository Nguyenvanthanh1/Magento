<?php

namespace Tigren\CustomerGroupCatalog\Plugin;

use Magento\Framework\App\Http\Context;

class HidePrice
{
    protected $context;

    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    public function afterToHtml(\Magento\Catalog\Pricing\Render\FinalPriceBox $subject, $result)
    {
        if (!$this->context->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH)) {
            return 'Please login to see the price';
        }
        return $result;
    }
}
