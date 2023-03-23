<?php

namespace Tigren\Testimonial\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\UrlInterface;

class Image extends AbstractHelper
{
    protected $DIR = 'profile/image';
    protected $urlBuilder;

    public function __construct(Context $context, UrlInterface $urlBuilder)
    {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context);
    }

    public function getUrlImage($imageUrl): string
    {
        return $this->urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]) . $this->DIR . DIRECTORY_SEPARATOR . $imageUrl;
    }
}
