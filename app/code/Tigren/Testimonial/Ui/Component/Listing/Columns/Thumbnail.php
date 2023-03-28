<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License (“OSL”) v. 3.0
 */

namespace Tigren\Testimonial\Ui\Component\Listing\Columns;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Tigren\Testimonial\Helper\Image;
use Tigren\Testimonial\Model\Question;
use Magento\Framework\UrlInterface;

/**
 * Class Thumbnail
 * @package Tigren\Testimonial\Ui\Component\Listing\Columns
 */
class Thumbnail extends \Magento\Ui\Component\Listing\Columns\Column
{

    const NAME = 'image';
    const ALT_FIELD = 'name';
    /**
     * @var Image
     */
    protected $helperImage;

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @param Image $helperImage
     * @param UrlInterface $urlBuilder
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        Image $helperImage,
        UrlInterface $urlBuilder,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        $this->helperImage = $helperImage;
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (!empty($dataSource) && isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                /** @var Question $item */
                $fieldName = $this->getName();
                if (!empty($fieldName)) {
                    $fileName = $item['profile_image'];
                    if (!empty($fileName)) {
                        $item[$fieldName . '_src'] = $this->helperImage->getUrlImage($fileName);
                        $item[$fieldName . '_orig_src'] = $this->helperImage->getUrlImage($fileName);
                        $item[$fieldName . '_alt'] = $this->getAlt($item);
                        $item[$fieldName . '_link'] = $this->urlBuilder->getUrl(
                            'tigren_testimonial/question/edit',
                            ['id' => $item['question_id']]);
                    }
                }
            }
        }
        return $dataSource;
    }

    /**
     * @param $row
     * @return null
     */
    protected function getAlt($row)
    {
        $altField = $this->getData('config/altField') ?: self::ALT_FIELD;
        return $row[$altField] ?? null;
    }
}
