<?php

namespace Riverstone\ShopbyBrand\Model;

use Magento\Framework\View\Element\UiComponent\DataProvider\DataProviderInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Riverstone\ShopbyBrand\Model\ResourceModel\Brand\CollectionFactory;

class DataProvider extends AbstractDataProvider implements DataProviderInterface
{
    /**
     * @var ResourceModel\Brand\Collection
     */
    protected $collection;
    /**
     * @var loaded data
     */
    protected $loadedData;
    /**
     * @var name
     */
    protected $name;
    /**
     * @var primary field name
     */
    protected $primaryFieldName;
    /**
     * @var requested field name
     */
    protected $requestFieldName;
    /**
     * @var collection
     */
    protected $collectionFactory;

    /**
     * DataProvider constructor.
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get the data
     *
     * @return array|mixed|loaded
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        foreach ($items as $item) {
            $data = $item->getData();

            if (isset($data['customer_group'])) {
                $data['customer_group'] = json_decode($data['customer_group'], true);
            }

            if (isset($data['store'])) {
                $data['store'] = json_decode($data['store'], true);
            }

            if (isset($data['image'])) {
                $data['image'] = [
                    [
                        'url' => $item->getImage(),
                        'name' => basename($item->getImage())
                    ]
                ];
            }

            if (isset($data['banner_image'])) {
                $data['banner_image'] = [
                    [
                        'url' => $item->getBannerImage(),
                        'name' => basename($item->getBannerImage())
                    ]
                ];
            }

            $this->loadedData[$item->getId()] = $data;
        }

        return $this->loadedData;
    }
}
