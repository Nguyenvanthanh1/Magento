<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License (“OSL”) v. 3.0
 */

namespace Tigren\CustomerGroupCatalog\Plugin;

use Magento\Catalog\Model\Product;

class AddPriceDiscount
{

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
        return $result . $price;

    }
}
