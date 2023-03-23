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
        $this->setData('name', $name);
    }

    public function getName()
    {
        $this->getData('name');
    }

    public function getCompany()
    {
        $this->getData('company');
    }

    public function setCompany($company)
    {
        $this->setData('company', $company);
    }

    public function setProfileImage($profileImage)
    {
        $this->setData('profile_image', $profileImage);
    }

    public function getProfileImage()
    {
        $this->getData('profile_image');
    }

    public function setStatus($status)
    {
        $this->setData('status', $status);
    }

    public function getStatus()
    {
        $this->getData('status');
    }

    public function getQuestionId()
    {
        $this->getData('question_id');
    }

    public function setQuestionId($questionId)
    {
        $this->setData('question_id', $questionId);
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
