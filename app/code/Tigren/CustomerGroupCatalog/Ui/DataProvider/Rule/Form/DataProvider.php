<?php

namespace Tigren\CustomerGroupCatalog\Ui\DataProvider\Rule\Form;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\Rule\CollectionFactory;

class DataProvider extends AbstractDataProvider
{

    protected $ruleCollection;

    public function __construct(
        CollectionFactory $ruleCollection,
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $ruleCollection->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        return [];
    }
}
