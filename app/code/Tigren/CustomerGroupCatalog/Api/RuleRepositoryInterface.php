<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License (“OSL”) v. 3.0
 */

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
