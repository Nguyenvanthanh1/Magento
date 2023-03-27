<?php

namespace Tigren\Testimonial\Ui\Component\Listing\Columns;


use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;

class Rating extends \Magento\Ui\Component\Listing\Columns\Column
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
            foreach ($dataSource['data']['items'] as &$item) {
                $rating = $item['rating'];
                if (!empty($rating)) {
                    $data = '';
                    for ($i = 1; $i <= (int)$rating; $i++) {
                        $data = $data . '<span style="color:#f5e431">&#10029; </span>';
                    }
                    $item['rating'] = $data;
                }
            }
        }
        return $dataSource;
    }
}
