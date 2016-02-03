<?php

namespace Training\Orm\Setup;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute as CatalogAttribute;
use Magento\Catalog\Setup\CategorySetup;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Store\Model\StoreManagerInterface as StoreManager;
use Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * Upgrade Data script
 * @codeCoverageIgnore
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * Category setup factory
     *
     * @var CategorySetupFactory
     */
    private $catalogSetupFactory;

    /**
     * @var StoreManager
     */
    private $storeManager;

    public function __construct(CategorySetupFactory $categorySetupFactory, StoreManager $storeManager) {
        $this->catalogSetupFactory = $categorySetupFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if ($context->getVersion()
            && version_compare($context->getVersion(), '0.0.2') < 0
        ) {
            $admin = $this->storeManager->getStore('admin')->getId();
            $default = $this->storeManager->getStore('default')->getId();

            $catalogSetup = $this->catalogSetupFactory->create(['setup' => $setup]);
            $catalogSetup->addAttribute(Product::ENTITY, 'example_multiselect', [
                'label' => 'Example Multi-Select',
                'input' => 'multiselect',
                'visible_on_front' => 1,
                'backend' => ArrayBackend::class,
                'required' => 0,
                'global' => CatalogAttribute::SCOPE_STORE,
                'option' => [
                    'order' => ['option1' => 10, 'options2' => 20],
                    'value' => [
                        'option1' => [
                            $admin => 'Admin Label 1',
                            $default => 'Frontend Label 1'
                        ],
                        'option2' => [
                            $admin => 'Admin Label 2',
                            $default => 'Frontend Label 2'
                        ],
                    ]
                ]
            ]);
        }

        if ($context->getVersion()
            && version_compare($context->getVersion(), '0.0.3') < 0
        ) {
            $catalogSetup = $this->catalogSetupFactory->create(['setup' => $setup]);
            $catalogSetup->updateAttribute(Product::ENTITY, 'example_multiselect', [
                'frontend_model' => \Training\Orm\Entity\Attribute\Frontend\HtmlList::class,
                'is_html_allowed_on_front' => 1
            ]);
        }

        $setup->endSetup();
    }
}
