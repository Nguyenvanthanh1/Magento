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

    /**
     * @return int
     */
    public function getQuestionId(): int;

    /**
     * @param $questionId
     * @return int
     */
    public function setQuestionId($questionId): int;

    /**
     * @param $name
     * @return string
     */
    public function setName($name): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getCompany(): string;

    /**
     * @param $company
     * @return string
     */
    public function setCompany($company): string;

    /**
     * @param $profileImage
     * @return string
     */
    public function setProfileImage($profileImage): string;

    /**
     * @return string
     */
    public function getProfileImage(): string;

    /**
     * @param $status
     * @return int
     */
    public function setStatus($status): int;

    /**
     * @return int
     */
    public function getStatus(): int;
}
