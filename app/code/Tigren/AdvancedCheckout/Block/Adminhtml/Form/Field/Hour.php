<?php

namespace Tigren\AdvancedCheckout\Block\Adminhtml\Form\Field;

class Hour extends \Magento\Framework\View\Element\Html\Select
{

    public function setInputName($value)
    {
        return $this->setName($value);
    }
    public function setInputId($value)
    {
        return $this->setId($value);
    }

    public function _toHtml(): string
    {
        if (!$this->getOptions()) {
            $this->setOptions($this->getHour());
        }
        return parent::_toHtml();
    }

    public function getHour()
    {
        for ($i = 1; $i <= 24; $i++) {
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
