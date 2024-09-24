<?php

namespace Riverstone\ShopbyBrand\Block\Brand;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Riverstone\ShopbyBrand\Model\BrandFactory;
use Magento\Catalog\Helper\Image;

class ProductList extends Template
{
    /**
     * @var CollectionFactory
     */
    protected $pdtCollectionFactory;
    /**
     * @var barndId
     */
    protected $brandId;
    /**
     * @var BrandFactory
     */
    protected $brandFactory;
    /**
     * @var Image
     */
    protected $image;

    /**
     * ProductList constructor.
     *
     * @param Context $context
     * @param CollectionFactory $pdtCollectionFactory
     * @param BrandFactory $brandFactory
     * @param Image $image
     * @param array $data
     */
    public function __construct(
        Context $context,
        CollectionFactory $pdtCollectionFactory,
        BrandFactory $brandFactory,
        Image $image,
        array $data = []
    ) {
        $this->pdtCollectionFactory = $pdtCollectionFactory;
        $this->brandFactory = $brandFactory;
        $this->image = $image;
        parent::__construct($context, $data);
    }

    /**
     * Get the Products
     *
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection|null
     */
    public function getProducts()
    {
        $brandId = $this->getBrandId();
        if (!$brandId) {
            return null;
        }

        $collection = $this->pdtCollectionFactory->create();
        $collection->addAttributeToSelect(['name', 'sku', 'price', 'image'])
                   ->addAttributeToFilter('brand_name', ['eq' => $brandId])
                   ->load();

        return $collection;
    }

    /**
     * Set the brand Id
     *
     * @param int $brandId
     * @return $this
     */
    public function setBrandId($brandId)
    {
        $this->brandId = $brandId;
        return $this;
    }

    /**
     * Get the brand id
     *
     * @return barndId
     */
    public function getBrandId()
    {
        return $this->brandId;
    }

    /**
     * Get the Image Url
     *
     * @param collection $product
     * @return string
     */
    public function getImageUrl($product)
    {
        return $this->image->init($product, 'product_page_image_small')->getUrl();
    }

    /**
     * Get the add to cart url
     *
     * @param collection $product
     * @return string
     */
    public function getAddToCartUrl($product)
    {
        return $this->getUrl('checkout/cart/add', ['product' => $product->getId()]);
    }

    /**
     * Get the Brand Details
     *
     * @return array|mixed|null
     */
    public function getBrandDetails()
    {
        $brandId = $this->getBrandId();
        if (!$brandId) {
            return null;
        }

        $brand = $this->brandFactory->create()->load($brandId);
        return $brand->getData();
    }
}
