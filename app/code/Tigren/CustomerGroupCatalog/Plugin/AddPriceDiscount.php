<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License (“OSL”) v. 3.0
 */

namespace Tigren\CustomerGroupCatalog\Plugin;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Pricing\Price\FinalPrice;

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

        $priceRender = $subject->getLayout()->getBlock('product.price.render.default');
        if (!$priceRender) {
            $priceRender = $subject->getLayout()->createBlock(
                \Magento\Framework\Pricing\Render::class,
                'product.price.render.default',
                ['data' => ['price_render_handle' => 'catalog_product_prices_discount']]
            );
        }
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info(print_r(''), true);
        return $result;

    }
}
