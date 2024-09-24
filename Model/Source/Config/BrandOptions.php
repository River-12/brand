<?php

namespace Riverstone\ShopbyBrand\Model\Source\Config;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Riverstone\ShopbyBrand\Model\ResourceModel\Brand\CollectionFactory as BrandCollectionFactory;

class BrandOptions extends AbstractSource
{
    /**
     * @var BrandCollectionFactory
     */
    protected $bndCollectionFactory;
    /**
     * @var option
     */
    protected $optionFactory;

    /**
     * BrandOptions constructor.
     *
     * @param BrandCollectionFactory $bndCollectionFactory
     */
    public function __construct(BrandCollectionFactory $bndCollectionFactory)
    {
        $this->bndCollectionFactory = $bndCollectionFactory;
    }

    /**
     * Get all options
     *
     * @return array|null
     */
    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options = $this->getBrandOptions();
        }
        return $this->_options;
    }

    /**
     * Get Brand Options
     *
     * @return array
     */
    protected function getBrandOptions()
    {
        $brandCollection = $this->bndCollectionFactory->create();
        $options = [];

        foreach ($brandCollection as $brand) {
            $options[] = ['label' => $brand->getBrandName(), 'value' => $brand->getId()];
        }

        return $options;
    }
}
