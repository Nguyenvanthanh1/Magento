<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License (“OSL”) v. 3.0
 */

namespace Tigren\Testimonial\Helper;

use Exception;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Framework\UrlInterface;
use Magento\MediaStorage\Model\File\UploaderFactory;

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
     * @var UploaderFactory
     */
    protected $uploader;

    /**
     * @var Filesystem
     */
    protected $fileSystem;

    /**
     * @var WriteInterface
     */
    protected $mediaDirectory;

    /**
     * @param Context $context
     * @param UploaderFactory $uploader
     * @param Filesystem $filesystem
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function __construct(
        Context $context,
        UploaderFactory $uploader,
        Filesystem $filesystem
    ) {
        $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->uploader = $uploader;
        $this->fileSystem = $filesystem;
        parent::__construct($context);
    }

    /**
     * @param $imageUrl
     * @return string
     */
    public function getUrlImage($imageUrl): string
    {
        return $this->_urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]) . $this->DIR . DIRECTORY_SEPARATOR . $imageUrl;
    }

    /**
     * @throws LocalizedException
     */
    public function uploadImage($file)
    {
        if (!empty($file)) {
            $uploaderFile = $this->uploader->create(['fileId' => 'image']);
            $uploaderFile->setAllowedExtensions($this->getAllowExtensions());
            $uploaderFile->setAllowRenameFiles(true);
            $mediaPath = $this->mediaDirectory->getAbsolutePath('profile/image');
            try {
                return $uploaderFile->save($mediaPath);
            } catch (Exception $e) {
                throw new LocalizedException(__('File can not be saved to the destination folder.'));
            }
        }
    }

    /**
     * @return string[]
     */
    public function getAllowExtensions(): array
    {
        return ['jpg', 'jpeg', 'png', 'gif'];
    }
}
