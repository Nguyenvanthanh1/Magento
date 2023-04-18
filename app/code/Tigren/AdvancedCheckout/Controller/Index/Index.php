<?php

namespace Tigren\AdvancedCheckout\Controller\Index;

use Magento\Catalog\Model\ProductRepository;
use Magento\Checkout\Model\SessionFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{
    protected $productRepository;

    protected $sessionFactory;

    public function __construct(SessionFactory $sessionFactory, ProductRepository $productRepository, Context $context)
    {
        $this->sessionFactory = $sessionFactory;
        $this->productRepository = $productRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        $sku = $this->getRequest()->getParam('sku');
        $message = [];
        $checkProduct = 0;
        if (!empty($sku)) {
            $product = $this->productRepository->get($sku);
            $productId = $product->getId();
            $quoteItem = $this->sessionFactory->create()->getQuote()->getAllItems();
            if (!empty($quoteItem)) {
                foreach ($quoteItem as $item) {
                    if ($item->getProductId() === $productId) {
                        $checkProduct = (int)$item->getQty();
                        break;
                    }
                }
            }

            $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
            $allCheckMultiple = $product->getCustomAttribute('is_allow_multiple') ? $product->getCustomAttribute('is_allow_multiple')->getValue() : 0;
            if (!empty($productId) && !$allCheckMultiple && $checkProduct >= 1) {
                $message['message'] = 'show';
            } else {
                $message['message'] = 'hide';
            }
        }
        return $resultJson->setData($message);
    }
}
