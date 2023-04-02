<?php

namespace Tigren\CustomerGroupCatalog\Api;

use Tigren\CustomerGroupCatalog\Api\Data\RuleInterface;

/**
 * Interface RuleRepositoryInterface
 * @package Tigren\CustomerGroupCatalog\Api
 */
interface RuleRepositoryInterface
{
    /**
     * @param Data\RuleInterface $rule
     * @return RuleInterface
     */
    public function save(\Tigren\CustomerGroupCatalog\Api\Data\RuleInterface $rule);

    /**
     * @param int $ruleId
     * @return RuleInterface
     */
    public function get($ruleId);

    /**
     * @param Data\RuleInterface $rule
     * @return bool
     */
    public function delete(\Tigren\CustomerGroupCatalog\Api\Data\RuleInterface $rule);

    /**
     * @param int $ruleId
     * @return bool
     */
    public function deleteById($ruleId);
}
