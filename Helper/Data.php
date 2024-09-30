<?php

namespace Riverstone\ShopbyBrand\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    protected const XML_PATH_BRAND_GENERAL_ENABLE = 'brand/general/enable';
    protected const XML_PATH_PRODUCT_BRAND_LOGO = 'brand/product/brand_logo';
    protected const XML_PATH_PRODUCT_BRAND_DESCRIPTION = 'brand/product/brand_description';
    protected const XML_PATH_PRODUCT_BRAND_NAME = 'brand/product/brand_name';
    protected const XML_PATH_CATEGORY_BRAND_LOGO = 'brand/category/brand_logo';
    protected const XML_PATH_CATEGORY_BRAND_DESCRIPTION = 'brand/category/brand_description';
    protected const XML_PATH_CATEGORY_BRAND_NAME = 'brand/category/brand_name';

    /**
     * Check module enabled
     *
     * @return bool
     */
    public function isModuleEnabled()
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_BRAND_GENERAL_ENABLE, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Show the brand logo
     *
     * @return bool
     */
    public function showBrandLogoProduct()
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_PRODUCT_BRAND_LOGO, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Show Brand Description
     *
     * @return bool
     */
    public function showBrandDescriptionProduct()
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_PRODUCT_BRAND_DESCRIPTION, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Show the brand name
     *
     * @return bool
     */
    public function showBrandNameProduct()
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_PRODUCT_BRAND_NAME, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Show the brand logo
     *
     * @return bool
     */
    public function showBrandLogoCategory()
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_CATEGORY_BRAND_LOGO, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Show the brand Description
     *
     * @return bool
     */
    public function showBrandDescriptionCategory()
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_CATEGORY_BRAND_DESCRIPTION, ScopeInterface::SCOPE_STORE);
    }

    /**
     * SHow the brand name
     *
     * @return bool
     */
    public function showBrandNameCategory()
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_CATEGORY_BRAND_NAME, ScopeInterface::SCOPE_STORE);
    }
}
