<?php

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

    protected $uploader;

    protected $fileSystem;

    protected $mediaDirectory;

    /**
     * @param Context $context
     * @param WriteInterface $mediaDirectory
     * @param UploaderFactory $uploader
     * @param Filesystem $filesystem
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

    public function getAllowExtensions(): array
    {
        return ['jpg', 'jpeg', 'png', 'gif'];
    }

    public function getFileName($path, $filename)
    {
        $path = $path !== null ? rtrim($path, '/') : '';
        $filename = $filename !== null ? ltrim($filename, '/') : '';

        return $path . DIRECTORY_SEPARATOR . $filename;
    }

}
