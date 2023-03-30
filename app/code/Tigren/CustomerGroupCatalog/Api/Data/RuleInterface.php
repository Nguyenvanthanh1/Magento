<?php

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

    public function setRuleId($ruleId);

    public function getRuleId();

    public function setName($name);

    public function getName();

    public function setActive($active);

    public function getActive();

    public function getPriority();

    public function setPriority($priority);

    public function setStartTime($startTime);

    public function getStartTime();

    public function setEndTime($endTime);

    public function getEndTime();

    public function setUseRangeDate($useRangeDate);

    public function getUseRangeDate();
}
