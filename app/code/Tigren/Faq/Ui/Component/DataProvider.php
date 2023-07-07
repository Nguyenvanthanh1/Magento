<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License (“OSL”) v. 3.0
 */

namespace Tigren\Faq\Ui\Component;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Tigren\Faq\Model\ResourceModel\Question\CollectionFactory;

class DataProvider extends AbstractDataProvider
{

    private $collectionFactory;

    public function __construct(
        CollectionFactory $collectionFactory,
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collectionFactory = $collectionFactory;
    }

    public function getCollection(): \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
    {
        $this->collection = $this->collectionFactory->create();
        return $this->collection;
    }

    public function getData()
    {
        return [];
    }

    public function getSearchResult()
    {
        return null;
    }
}