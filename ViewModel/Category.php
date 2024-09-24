<?php

namespace Riverstone\ShopbyBrand\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Riverstone\ShopbyBrand\Helper\Data as BrandHelper;
use Magento\Framework\Registry;
use Riverstone\ShopbyBrand\Model\BrandFactory;

class Category implements ArgumentInterface
{
    /**
     * @var Registry
     */
    protected $registry;
    /**
     * @var BrandFactory
     */
    protected $brandFactory;
    /**
     * @var BrandHelper
     */
    protected $helperdata;

    /**
     * Category constructor.
     *
     * @param Registry $registry
     * @param BrandFactory $brandFactory
     * @param BrandHelper $helperdata
     */
    public function __construct(
        Registry $registry,
        BrandFactory $brandFactory,
        BrandHelper $helperdata
    ) {
        $this->registry = $registry;
        $this->brandFactory = $brandFactory;
        $this->helperdata = $helperdata;
    }

    /**
     * Get whether the module is enabled or not
     *
     * @return bool
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getModuleEnable()
    {
        return $this->helperdata->isModuleEnabled();
    }

    /**
     * Get the Brand Details
     *
     * @param Object $product
     * @return array
     */
    public function getBrandDetails($product)
    {
        if ($this->helperdata->isModuleEnabled()) {
            $brandAttributeValue = $product->getCustomAttribute('brand_name');
            if (!$brandAttributeValue) {
                return [];
            }

            $brandName = $brandAttributeValue->getValue();
            $brandModel = $this->brandFactory->create();
            $brandModel->load($brandName, 'id');

            return [
                'name' => $brandModel->getBrandName(),
                'image' => $brandModel->getImage(),
                'description' => $brandModel->getDescription(),
            ];

        }
    }

    /**
     * Get the brand name
     *
     * @return bool
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getBrandName()
    {
        return $this->helperdata->showBrandNameCategory();
    }

    /**
     * Get the brand logo
     *
     * @return bool
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getBrandLogo()
    {
        return $this->helperdata->showBrandLogoCategory();
    }

    /**
     * Get the brand description
     *
     * @return bool
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getBrandDescription()
    {
        return $this->helperdata->showBrandDescriptionCategory();
    }
}
