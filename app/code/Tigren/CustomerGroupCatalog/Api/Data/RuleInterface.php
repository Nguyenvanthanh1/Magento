<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License (“OSL”) v. 3.0
 */

namespace Tigren\CustomerGroupCatalog\Api\Data;

interface RuleInterface
{
    public const RULE_ID = 'rule_id';
    public const NAME = 'name';
    public const IS_ACTIVE = 'active';
    public const CONDITIONS_SERIALIZED = 'conditions_serialized';
    public const FROM_DATE = 'start_time';
    public const TO_DATE = 'end_time';
    public const DATE_RANGE_ENABLED = 'use_range_date';
    public const PRIORITY = 'priority';

    /**
     * @param $ruleId
     * @return mixed
     */
    public function setRuleId($ruleId);

    /**
     * @return mixed
     */
    public function getRuleId();

    /**
     * @param $name
     * @return mixed
     */
    public function setName($name);

    /**
     * @return mixed
     */
    public function getName();

    /**
     * @param $active
     * @return mixed
     */
    public function setActive($active);

    /**
     * @return mixed
     */
    public function getActive();

    /**
     * @return mixed
     */
    public function getPriority();

    /**
     * @param $priority
     * @return mixed
     */
    public function setPriority($priority);

    /**
     * @param $startTime
     * @return mixed
     */
    public function setStartTime($startTime);

    /**
     * @return mixed
     */
    public function getStartTime();

    /**
     * @param $endTime
     * @return mixed
     */
    public function setEndTime($endTime);

    /**
     * @return mixed
     */
    public function getEndTime();

    /**
     * @param $useRangeDate
     * @return mixed
     */
    public function setUseRangeDate($useRangeDate);

    /**
     * @return mixed
     */
    public function getUseRangeDate();
}
