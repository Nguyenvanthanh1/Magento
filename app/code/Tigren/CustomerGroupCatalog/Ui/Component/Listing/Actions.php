<?php

namespace Tigren\CustomerGroupCatalog\Ui\Component\Listing;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class Actions extends Column
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
                $item[$this->getName()]['edit'] = [
                    'label' => 'Edit',
                    'href' => $this->context->getUrl('customer_catalog/rule/edit', ['id' => $item['rule_id']])

                ];
            }
        }
        return $dataSource;
    }
}
