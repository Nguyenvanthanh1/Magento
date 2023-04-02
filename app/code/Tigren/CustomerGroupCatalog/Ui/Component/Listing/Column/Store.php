<?php

namespace Tigren\CustomerGroupCatalog\Ui\Component\Listing\Column;

use Magento\Framework\Escaper;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\System\Store as SystemStore;
use Magento\Ui\Component\Listing\Columns\Column;
use Tigren\CustomerGroupCatalog\Model\RuleFactory;

class Store extends Column
{
    protected $ruleFactory;

    protected $escaper;

    protected $systemStore;

    protected $storeKey;

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

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getName()] = $this->prepareItem($item);
            }
        }
        return $dataSource;
    }

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
