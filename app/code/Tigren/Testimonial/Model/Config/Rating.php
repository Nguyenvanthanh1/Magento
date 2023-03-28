<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License (“OSL”) v. 3.0
 */

namespace Tigren\Testimonial\Model\Config;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class Rating
 * @package Tigren\Testimonial\Model\Config
 */
class Rating implements ArrayInterface
{

    /**
     * @return array[]
     */
    public function toOptionArray()
    {
        return [
            ['value' => '', 'label' => __('-- Please Select --')],
            ['value' => 1, 'label' => __('1 Star')],
            ['value' => 2, 'label' => __('2 Star')],
            ['value' => 3, 'label' => __('3 Star')],
            ['value' => 4, 'label' => __('4 Star')],
            ['value' => 5, 'label' => __('5 Star')],
        ];

    }
}
