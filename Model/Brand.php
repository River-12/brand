<?php

namespace Riverstone\ShopbyBrand\Model;

use Magento\Framework\Model\AbstractModel;
use Riverstone\ShopbyBrand\Model\ResourceModel\Brand as ResourceModel;

class Brand extends AbstractModel
{
    /**
     * Construct
     *
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}
