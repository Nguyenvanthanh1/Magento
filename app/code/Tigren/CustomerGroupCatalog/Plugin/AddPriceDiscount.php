<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License (“OSL”) v. 3.0
 */

namespace Tigren\CustomerGroupCatalog\Plugin;

use Magento\Catalog\Model\Product;
use Magento\Framework\App\Http\Context;

/**
 * Class AddPriceDiscount
 * @package Tigren\CustomerGroupCatalog\Plugin
 */
class AddPriceDiscount
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
     * @param \Magento\CatalogWidget\Block\Product\ProductsList $subject
     * @param $result
     * @param Product $product
     * @param $priceType
     * @param $renderZone
     * @param array $arguments
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function afterGetProductPriceHtml(
        \Magento\CatalogWidget\Block\Product\ProductsList $subject,
        $result,
        Product $product,
        $priceType = null,
        $renderZone = \Magento\Framework\Pricing\Render::ZONE_ITEM_LIST,
        array $arguments = []
    ) {

        $priceCustomRender = $subject->getLayout()->getBlock('product.price.render.custom');
        $price = $priceCustomRender->render('final_price', $product, $arguments);
        if (!empty($priceCustomRender) && !$this->context->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH)) {
            return $result;
        }
        return $result . $price;
    }
}
