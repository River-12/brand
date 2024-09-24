<?php

namespace Riverstone\ShopbyBrand\Model\Source\Config;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    /**
     * Check string
     *
     * @const string
     */
    protected const DISABLE = 0;

    /**
     * Int fun
     *
     * @const int
     */
    protected const ENABLE = 1;

    /**
     * @const int
     */
    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        $array = [];
        foreach ($this->toOptionArray() as $item) {
            $array[$item['value']] = $item['label'];
        }
        return $array;
    }

    /**
     * Options int
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::DISABLE, 'label' => __('Disabled')],
            ['value' => self::ENABLE, 'label' => __('Enabled')],

        ];
    }
}
