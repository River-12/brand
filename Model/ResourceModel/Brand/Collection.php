<?php

namespace Riverstone\ShopbyBrand\Model\ResourceModel\Brand;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * Construct
     *
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _construct()
    {
        $this->_init('Riverstone\ShopbyBrand\Model\Brand', 'Riverstone\ShopbyBrand\Model\ResourceModel\Brand');
    }
}
