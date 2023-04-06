<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License (“OSL”) v. 3.0
 */

namespace Tigren\CustomerGroupCatalog\Plugin;

use Magento\Framework\App\Http\Context;

/**
 * Class HideAddToCart
 * @package Tigren\CustomerGroupCatalog\Plugin
 */
class HideAddToCart
{
    /**
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    /**
     * @param \Magento\Catalog\Model\Product $subject
     * @param $result
     * @return false|mixed
     */
    public function afterIsSalable(\Magento\Catalog\Model\Product $subject, $result)
    {
        if (!$this->context->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH)) {
            return false;
        }
        return $result;
    }
}
