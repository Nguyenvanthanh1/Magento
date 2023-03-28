<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License (“OSL”) v. 3.0
 */

namespace Tigren\Testimonial\Api\Data;

const QUESTION_ID = 'question_id';

const NAME = 'name';

const EMAIL = 'email';

const PROFILE_IMAGE = 'profile_image';

const STATUS = 'status';

const COMPANY = 'question_id';

interface QuestionInterface
{
    /**
     * @return mixed
     */
    public function getQuestionId();

    /**
     * @param $questionId
     * @return mixed
     */
    public function setQuestionId($questionId);

    /**
     * @param $name
     * @return mixed
     */
    public function setName($name);

    /**
     * @return string|null
     */
    public function getName();

    /**
     * @return mixed
     */
    public function getCompany();

    /**
     * @param $company
     * @return mixed
     */
    public function setCompany($company);

    /**
     * @param $profileImage
     * @return mixed
     */
    public function setProfileImage($profileImage);

    /**
     * @return mixed
     */
    public function getProfileImage();

    /**
     * @return mixed
     */
    public function getRating();

    /**
     * @param $rating
     * @return mixed
     */
    public function setRating($rating);

    /**
     * @param $status
     * @return mixed
     */
    public function setStatus($status);

    /**
     * @return mixed
     */
    public function getStatus();
}
