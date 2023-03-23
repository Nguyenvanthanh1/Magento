<?php

namespace Tigren\Testimonial\Ui\Component\Listing;

use Magento\Ui\DataProvider\Modifier\PoolInterface;

class QuestionDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $modifiersPool;

    public function __construct(
        PoolInterface $modifiersPool,
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = [],
    ) {
        $this->modifiersPool = $modifiersPool;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        return $this->getCollection();
    }
}
