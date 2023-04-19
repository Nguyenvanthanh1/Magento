<?php

namespace Tigren\AdvancedCheckout\Block\Adminhtml\Config;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\View\Helper\SecureHtmlRenderer;

class DeliveryDate extends AbstractFieldArray
{
    public function __construct(Context $context, array $data = [], ?SecureHtmlRenderer $secureRenderer = null)
    {
        parent::__construct($context, $data, $secureRenderer);
    }

//    protected function _prepareArrayRow(\Magento\Framework\DataObject $row)
//    {
//        $options = [];
//        $hours = $row->getHourSelect();
//        $minutes = $row->getMinuteSelect();
//        if (count($hours) > 0) {
//            foreach ($hours as $hour) {
//                $options['option_' . $this->getHourSelect()->calcOptionHash($hour)]
//                    = 'selected="selected"';
//            }
//        }
//        if (count($minutes) > 0) {
//
//        }
//        $row->setData('option_extra_attrs', $options);
//    }
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $element->setTimeFormat("HH:mm:ss"); //set date and time as per requirment
        return parent::render($element);
    }
    public function getHourSelect()
    {
        return $this->getLayout()->createBlock(
            \Tigren\AdvancedCheckout\Block\Adminhtml\Form\Field\Hour::class,
            '',
            ['data' => ['is_render_to_js_template' => true]]
        );
    }

    public function getMinuteSelect()
    {

        return $this->getLayout()->createBlock(
            \Tigren\AdvancedCheckout\Block\Adminhtml\Form\Field\Minute::class,
            '',
            ['data' => ['is_render_to_js_template' => true]]
        );
    }

    protected function _prepareToRender()
    {
        $this->addColumn('From',
            [
                'label' => __('From'),
                'id' => 'select_date',
            ]
        );
        $this->addColumn('To', [
            'label' => __('To'),
        ]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }
}
