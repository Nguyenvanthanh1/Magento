<?php

namespace Tigren\Testimonial\Ui\Component\Form;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Tigren\Testimonial\Helper\Image;
use Tigren\Testimonial\Model\ResourceModel\Question\Collection;
use Tigren\Testimonial\Model\ResourceModel\Question\CollectionFactory;

/**
 * DataProvider component.
 * @property Collection $collection
 */
class DataProvider extends AbstractDataProvider
{

    protected $loadedData;

    protected $helperImage;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $questionFactory,
        Image $helperImage,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $questionFactory->create();
        $this->helperImage = $helperImage;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data.
     *
     * @return array
     */
    public function getData()
    {
        if (null !== $this->loadedData) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $item) {
            $itemData = $item->getData();
            $imageName = $itemData['profile_image'];
            if(!empty($imageName)) {
                unset($itemData['profile_image']);
                $itemData['profile_image'][0] = [
                    'name' => $imageName,
                    'url' => $this->helperImage->getUrlImage($imageName)
                ];
            }
            /** @var \Tigren\Testimonial\Model\Question $item */
            $this->loadedData[$item->getId()] = $itemData;
        }
        return $this->loadedData;
    }
}
