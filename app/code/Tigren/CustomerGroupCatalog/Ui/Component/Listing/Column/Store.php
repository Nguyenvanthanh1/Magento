<?php
/*
 * @author  Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license  Open Software License (“OSL”) v. 3.0
 */

namespace Tigren\CustomerGroupCatalog\Ui\Component\Listing\Column;

use Magento\Framework\Escaper;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\System\Store as SystemStore;
use Magento\Ui\Component\Listing\Columns\Column;
use Tigren\CustomerGroupCatalog\Model\RuleFactory;

/**
 * Class Store
 * @package Tigren\CustomerGroupCatalog\Ui\Component\Listing\Column
 */
class Store extends Column
{
    /**
     * @var RuleFactory
     */
    protected $ruleFactory;

    /**
     * @var Escaper
     */
    protected $escaper;

    /**
     * @var SystemStore
     */
    protected $systemStore;

    /**
     * @var mixed|string
     */
    protected $storeKey;

    /**
     * @param RuleFactory $ruleFactory
     * @param Escaper $escaper
     * @param SystemStore $systemStore
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param $storeKey
     * @param array $components
     * @param array $data
     */
    public function __construct(
        RuleFactory $ruleFactory,
        Escaper $escaper,
        SystemStore $systemStore,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        $storeKey = 'store_id',
        array $components = [],
        array $data = []
    ) {
        $this->ruleFactory = $ruleFactory;
        $this->systemStore = $systemStore;
        $this->escaper = $escaper;
        $this->storeKey = $storeKey;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getName()] = $this->prepareItem($item);
            }
        }
        return $dataSource;
    }

    /**
     * @param array $item
     * @return \Magento\Framework\Phrase|string
     */
    protected function prepareItem(array $item)
    {
        $content = '';
        if (!isset($item[$this->storeKey])) {
            $origStores = $this->ruleFactory->create()->getResource()->getStoreByRuleId($item['rule_id']);
        }

        if (empty($origStores)) {
            return '';
        }
        if (!is_array($origStores)) {
            $origStores = [$origStores];
        }
        if (in_array(0, $origStores) && count($origStores) == 1) {
            return __('All Store Views');
        }

        $data = $this->systemStore->getStoresStructure(false, $origStores);

        foreach ($data as $website) {
            $content .= $website['label'] . "<br/>";
            foreach ($website['children'] as $group) {
                $content .= str_repeat('&nbsp;', 3) . $this->escaper->escapeHtml($group['label']) . "<br/>";
                foreach ($group['children'] as $store) {
                    $content .= str_repeat('&nbsp;', 6) . $this->escaper->escapeHtml($store['label']) . "<br/>";
                }
            }
        }

        return $content;
    }
}
