<?php

namespace Tigren\AdvancedCheckout\Block\Adminhtml\Form\Field;

class Minute extends \Magento\Framework\View\Element\Html\Select
{
    public function _toHtml(): string
    {
        if (!$this->getOptions()) {
            $this->setOptions($this->getMinute());
        }
        return parent::_toHtml();
    }

    public function getMinute()
    {
        for ($i = 1; $i <= 60; $i++) {
            $label = $i;
            if ($i < 10) {
                $label = '0' . $i;
            }
            $hour[] = [
                'label' => $label,
                'value' => $i
            ];
        }
        return $hour;
    }
}
