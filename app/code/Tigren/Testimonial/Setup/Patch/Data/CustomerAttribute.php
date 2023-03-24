<?php

namespace Tigren\Testimonial\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Setup\EavSetup;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Customer\Setup\CustomerSetupFactory;

class CustomerAttribute implements DataPatchInterface
{

    protected $eavSetupFactory;

    protected $moduleDataSetupInterface;

    public function __construct(EavSetupFactory $eavSetupFactory, ModuleDataSetupInterface $moduleDataSetupInterface)
    {
        $this->moduleDataSetupInterface = $moduleDataSetupInterface;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }

    public function apply()
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetupInterface]);

        $eavSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'is_created_testimonial', [
            'type' => 'int',
            'backend' => '',
            'frontend' => '',
            'label' => 'Is Created Testimonial',
            'input' => 'select',
            'source' => \Magento\Eav\Model\Entity\Attribute\Source\Boolean::class,
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'required' => true,
            'user_defined' => false,
            'default' => false,
            'searchable' => false,
            'filterable' => false,
            'comparable' => false,
            'visible_on_front' => false,
            'unique' => false,
            'is_used_in_grid' => true,
            'is_visible_in_grid' => true
        ]);
    }
}
