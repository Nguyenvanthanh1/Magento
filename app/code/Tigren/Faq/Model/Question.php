<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License (“OSL”) v. 3.0
 */

namespace Tigren\Faq\Model;

use Magento\Framework\Model\AbstractModel;
use Tigren\Faq\Model\ResourceModel\Question as ResourceModel;

class Question extends AbstractModel
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'tigren_faq_question_model';

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
