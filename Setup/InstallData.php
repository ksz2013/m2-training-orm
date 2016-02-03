<?php

namespace Training\Orm\Setup;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute as CatalogAttribute;
use Magento\Catalog\Setup\CategorySetup;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    private $catalogSetupFactory;

    public function __construct(CategorySetupFactory $categorySetupFactory) {
        $this->catalogSetupFactory = $categorySetupFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var \Magento\Catalog\Setup\CategorySetup $categorySetup */
        $catalogSetup = $this->catalogSetupFactory->create(['setup' => $setup]);

        $catalogSetup->addAttribute(Product::ENTITY, 'flavour_from_setup_method', [
            'label' => 'Flavour From Setup Method',
            'visible_on_front' => 1,
            'required' => 0,
            'global' => CatalogAttribute::SCOPE_STORE
        ]);
    }

}
