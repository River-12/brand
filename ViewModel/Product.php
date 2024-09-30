<?php

namespace Riverstone\ShopbyBrand\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Registry;
use Riverstone\ShopbyBrand\Model\BrandFactory;
use Psr\Log\LoggerInterface;

class Product implements ArgumentInterface
{
    /**
     * @var product repository
     */
    protected $productRepository;
    /**
     * @var Registry
     */
    protected $registry;
    /**
     * @var BrandFactory
     */
    protected $brandFactory;
    /**
     * @var $logger
     */
    protected $logger;
    /**
     * @var \Magento\Catalog\Model\Product
     */
    protected $product;
    /**
     * @var \Riverstone\ShopbyBrand\Helper\Data
     */
    protected $helperdata;

    /**
     * Product constructor.
     *
     * @param \Magento\Catalog\Model\Product $product
     * @param Registry $registry
     * @param BrandFactory $brandFactory
     * @param \Riverstone\ShopbyBrand\Helper\Data $helperdata
     */
    public function __construct(
        \Magento\Catalog\Model\Product $product,
        Registry $registry,
        BrandFactory $brandFactory,
        \Riverstone\ShopbyBrand\Helper\Data $helperdata
    ) {
        $this->product = $product;
        $this->registry = $registry;
        $this->brandFactory = $brandFactory;
        $this->helperdata = $helperdata;
    }

    /**
     * Get the Product Atrribute Value
     *
     * @return array
     */
    public function getProductAttributeValue()
    {

        $moduleEnable = $this->helperdata->isModuleEnabled();
        if ($moduleEnable) {
            $prodvar = $this->registry->registry('current_product');
            $productId = $prodvar->getId();
            $product = $this->product->load($productId);
            $pdtattributevalue =$this->product->getResource()->getAttribute('brand_name')
            ->getFrontend()->getValue($product);

            $brandModel = $this->brandFactory->create();
            $brandModel->load($pdtattributevalue, 'brand_name');

            return [
            'name' => $brandModel->getBrandName(),
            'image' => $brandModel->getImage(),
            'description' => $brandModel->getDescription(),
            ];
        }
    }

    /**
     * Get the Brand name
     *
     * @return bool
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getBrandName()
    {
        return $this->helperdata->showBrandNameProduct();
    }

    /**
     * Get the brand logo
     *
     * @return bool
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getBrandLogo()
    {
        return $this->helperdata->showBrandLogoProduct();
    }

    /**
     * Get the Brnd Description
     *
     * @return bool
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getBrandDescription()
    {
        return $this->helperdata->showBrandDescriptionProduct();
    }
}
