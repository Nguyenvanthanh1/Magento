<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License (“OSL”) v. 3.0
 */

namespace Tigren\Faq\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Question extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'tigren_faq_question_resource_model';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('tigren_faq_question', 'question_id');
        $this->_useIsObjectNew = true;
    }
}
