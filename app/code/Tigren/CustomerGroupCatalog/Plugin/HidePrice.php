<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License (“OSL”) v. 3.0
 */

namespace Tigren\CustomerGroupCatalog\Plugin;

use Magento\Framework\App\Http\Context;

/**
 * Class HidePrice
 * @package Tigren\CustomerGroupCatalog\Plugin
 */
class HidePrice
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    /**
     * @param \Magento\Catalog\Pricing\Render\FinalPriceBox $subject
     * @param $result
     * @return mixed|string
     */
    public function afterToHtml(\Magento\Catalog\Pricing\Render\FinalPriceBox $subject, $result)
    {
        if (!$this->context->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH)) {
            return 'Please login to see the price';
        }
        return $result;
    }
}
