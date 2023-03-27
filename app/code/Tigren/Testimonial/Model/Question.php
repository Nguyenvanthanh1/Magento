<?php

namespace Tigren\Testimonial\Model;

use Magento\Framework\Model\AbstractModel;
use Tigren\Testimonial\Api\Data\QuestionInterface;
use Tigren\Testimonial\Model\ResourceModel\Question as ResourceModel;

class Question extends AbstractModel implements QuestionInterface
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'tigren_testimonial_question_model';

    public function setName($name)
    {
        return $this->setData('name', $name);
    }

    public function getName()
    {
        return $this->getData('name');
    }

    public function getCompany()
    {
        return $this->getData('company');
    }

    public function setCompany($company)
    {
        return $this->setData('company', $company);
    }

    public function setProfileImage($profileImage)
    {
        return $this->setData('profile_image', $profileImage);
    }

    public function getProfileImage()
    {
        return $this->getData('profile_image');
    }

    public function setStatus($status)
    {
        return $this->setData('status', $status);
    }

    public function getStatus()
    {
        return $this->getData('status');
    }

    public function getQuestionId()
    {
        return $this->getData('question_id');
    }

    public function setQuestionId($questionId)
    {
        return $this->setData('question_id', $questionId);
    }

    public function getRating()
    {
        return $this->getData('rating');
    }

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
