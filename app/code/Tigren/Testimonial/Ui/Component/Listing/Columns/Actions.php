<?php

namespace Tigren\Testimonial\Ui\Component\Listing\Columns;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;

class Actions extends \Magento\Ui\Component\Listing\Columns\Column
{

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $storeId = $this->context->getFilterParam('store_id');
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')]['edit'] = [
                    'href' => $this->context->getUrl('tigren_testimonial/question/edit',
                        ['id' => $item['question_id'], 'store' => $storeId]),
                    'label' => __('Edit'),
                    'hidden' => false,

                ];
                $item[$this->getData('name')]['delete'] = [
                    'href' => $this->context->getUrl('tigren_testimonial/question/delete',
                        ['id' => $item['question_id'], 'store' => $storeId]),
                    'label' => __('Delete'),
                    'hidden' => false,]
                ;
            }
        }
        return $dataSource;
    }
}
