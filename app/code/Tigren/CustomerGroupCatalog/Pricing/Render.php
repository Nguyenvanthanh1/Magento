<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License (“OSL”) v. 3.0
 */

namespace Tigren\CustomerGroupCatalog\Pricing;

use Magento\Framework\Pricing\Render\Layout;
use Magento\Framework\View\Element\Template;

/**
 * Class Render
 * @package Tigren\CustomerGroupCatalog\Pricing
 */
class Render extends \Magento\Framework\Pricing\Render
{
    /**
     * @param Template\Context $context
     * @param Layout $priceLayout
     * @param array $data
     */
    public function __construct(Template\Context $context, Layout $priceLayout, array $data = [])
    {
        parent::__construct($context, $priceLayout, $data);
    }

    /**
     * @param $priceCode
     * @param \Magento\Framework\Pricing\SaleableInterface $saleableItem
     * @param array $arguments
     * @return string
     */
    public function render(
        $priceCode,
        \Magento\Framework\Pricing\SaleableInterface $saleableItem,
        array $arguments = []
    ) {
        $useArguments = array_replace($this->_data, $arguments);

        /** @var \Magento\Framework\Pricing\Render\RendererPool $rendererPool */
        $rendererPool = $this->priceLayout->getBlock('render.product.prices.custom');
        if (!$rendererPool) {
            throw new \RuntimeException('Wrong Price Rendering layout configuration. Factory block is missed');
        }
        if ($saleableItem->getTypeId() === 'simple') {
            $saleableItem->setPrice('24.00000');
        }
        // obtain concrete Price Render
        $priceRender = $rendererPool->createPriceRender($priceCode, $saleableItem, $useArguments);
        return $priceRender->toHtml();
    }
}
