<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License (“OSL”) v. 3.0
 */

namespace Tigren\Testimonial\Model;

use Magento\Framework\Model\AbstractModel;
use Tigren\Testimonial\Api\Data\QuestionInterface;
use Tigren\Testimonial\Model\ResourceModel\Question as ResourceModel;

/**
 * Class Question
 * @package Tigren\Testimonial\Model
 */
class Question extends AbstractModel implements QuestionInterface
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'tigren_testimonial_question_model';

    /**
     * @param $name
     * @return mixed|Question
     */
    public function setName($name)
    {
        return $this->setData('name', $name);
    }

    /**
     * @return array|mixed|string|null
     */
    public function getName()
    {
        return $this->getData('name');
    }

    /**
     * @return array|mixed|null
     */
    public function getCompany()
    {
        return $this->getData('company');
    }

    /**
     * @param $company
     * @return mixed|Question
     */
    public function setCompany($company)
    {
        return $this->setData('company', $company);
    }

    /**
     * @param $profileImage
     * @return mixed|Question
     */
    public function setProfileImage($profileImage)
    {
        return $this->setData('profile_image', $profileImage);
    }

    /**
     * @return array|mixed|null
     */
    public function getProfileImage()
    {
        return $this->getData('profile_image');
    }

    /**
     * @param $status
     * @return mixed|Question
     */
    public function setStatus($status)
    {
        return $this->setData('status', $status);
    }

    /**
     * @return array|mixed|null
     */
    public function getStatus()
    {
        return $this->getData('status');
    }

    /**
     * @return array|mixed|null
     */
    public function getQuestionId()
    {
        return $this->getData('question_id');
    }

    /**
     * @param $questionId
     * @return mixed|Question
     */
    public function setQuestionId($questionId)
    {
        return $this->setData('question_id', $questionId);
    }

    /**
     * @return array|mixed|null
     */
    public function getRating()
    {
        return $this->getData('rating');
    }

    /**
     * @param $rating
     * @return mixed|Question
     */
    public function setRating($rating)
    {
        return $this->setData('rating', $rating);
    }

    /**
     * Initialize magento model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}
