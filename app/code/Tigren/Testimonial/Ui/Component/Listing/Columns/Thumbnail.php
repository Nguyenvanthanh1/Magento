<?php

namespace Tigren\Testimonial\Ui\Component\Listing\Columns;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Tigren\Testimonial\Helper\Image;
use Tigren\Testimonial\Model\Question;

class Thumbnail extends \Magento\Ui\Component\Listing\Columns\Column
{

    const NAME = 'image';
    const ALT_FIELD = 'name';
    protected $helperImage;

    public function __construct(
        Image $helperImage,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        $this->helperImage = $helperImage;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (!empty($dataSource) && isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                /** @var Question $item */
                $fieldName = $this->getName();
                if(!empty($fieldName)){
                    $fileName = $item['profile_image'];
                    if (isset($fileName)) {
                        $item[$fieldName . '_src'] = $this->helperImage->getUrlImage($fileName);
                        $item[$fieldName . '_orig_src'] = $this->helperImage->getUrlImage($fileName);
                        $item[$fieldName . '_alt'] = $this->getAlt($item);
                    }
                }
            }
        }
        return $dataSource;
    }

    protected function getAlt($row)
    {
        $altField = $this->getData('config/altField') ?: self::ALT_FIELD;
        return $row[$altField] ?? null;
    }
}
