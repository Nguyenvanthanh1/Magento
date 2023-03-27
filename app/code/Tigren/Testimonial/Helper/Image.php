<?php

namespace Tigren\Testimonial\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\UrlInterface;

/**
 * Class Image
 * @package Tigren\Testimonial\Helper
 */
class Image extends AbstractHelper
{
    /**
     * @var string
     */
    protected $DIR = 'profile/image';

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @param Context $context
     * @param UrlInterface $urlBuilder
     */
    public function __construct(Context $context, UrlInterface $urlBuilder)
    {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context);
    }

    /**
     * @param $imageUrl
     * @return string
     */
    public function getUrlImage($imageUrl): string
    {
        return $this->urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]) . $this->DIR . DIRECTORY_SEPARATOR . $imageUrl;
    }
}
