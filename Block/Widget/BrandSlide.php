<?php

namespace Riverstone\ShopbyBrand\Block\Widget;

use Magento\Framework\View\Element\Template;
use Riverstone\ShopbyBrand\Model\ResourceModel\Brand\CollectionFactory;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;

class BrandSlide extends Template implements \Magento\Widget\Block\BlockInterface
{
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * BrandCollectionFactory
     *
     * @var CollectionFactory
     */
    protected $bndCollectionFactory;

    /**
     * BrandSlider constructor.
     *
     * @param Context $context
     * @param CollectionFactory $bndCollectionFactory
     * @param StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        Context $context,
        CollectionFactory $bndCollectionFactory,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->brandCollectionFactory = $bndCollectionFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * Initialize Block BrandSlider
     *
     * @return void
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate("Riverstone_ShopbyBrand::brand_slider.phtml");
    }

    /**
     * Brand Collection
     *
     * @return \Riverstone\ShopbyBrand\Model\ResourceModel\Brand\Collection
     */
    public function getBrandCollection()
    {
        $brandCollection = $this->brandCollectionFactory->create();
            // $brandCollection->addFieldToFilter('status', 1); // Assuming '1' means enabled
        // $brandCollection->addStoreFilter($this->storeManager->getStore()->getId());
        // $brandCollection->setOrder('position', 'ASC'); // Assuming you want to order by position

        return $brandCollection;
    }
}
