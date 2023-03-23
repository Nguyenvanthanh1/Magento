<?php

namespace Tigren\Testimonial\Api\Data;

const QUESTION_ID = 'question_id';
const NAME = 'name';
const EMAIL = 'email';
const PROFILE_IMAGE = 'profile_image';
const STATUS = 'status';
const COMPANY = 'question_id';
interface QuestionInterface
{
    public function getQuestionId();

    public function setQuestionId($questionId);

    public function setName($name);

    public function getName();

    public function getCompany();

    public function setCompany($company);

    public function setProfileImage($profileImage);

    public function getProfileImage();

    public function setStatus($status);

    public function getStatus();

}
