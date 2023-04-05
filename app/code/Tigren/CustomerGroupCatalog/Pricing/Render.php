<?php

namespace Tigren\CustomerGroupCatalog\Pricing;

use Magento\Framework\Pricing\Render\Layout;
use Magento\Framework\View\Element\Template;

class Render extends \Magento\Framework\Pricing\Render
{
    public function __construct(Template\Context $context, Layout $priceLayout, array $data = [])
    {
        parent::__construct($context, $priceLayout, $data);
    }

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
