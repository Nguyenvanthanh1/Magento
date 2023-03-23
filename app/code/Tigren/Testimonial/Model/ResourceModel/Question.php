<?php

namespace Tigren\Testimonial\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Question extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'tigren_testimonial_question_resource_model';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('tigren_testimonial_question', 'question_id');
        $this->_useIsObjectNew = true;
    }
}
