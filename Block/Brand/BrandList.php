<?php

namespace Riverstone\ShopbyBrand\Block\Brand;

use Magento\Framework\View\Element\Template;
use Riverstone\ShopbyBrand\Model\BrandFactory;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Store\Model\StoreManagerInterface;

class BrandList extends Template
{
    /**
     * @var BrandFactory
     */
    protected $brandFactory;
    /**
     * @var CustomerSession
     */
    protected $customerSession;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * BrandList constructor.
     *
     * @param Template\Context $context
     * @param BrandFactory $brandFactory
     * @param CustomerSession $customerSession
     * @param StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        BrandFactory $brandFactory,
        CustomerSession $customerSession,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->brandFactory = $brandFactory;
        $this->customerSession = $customerSession;
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    /**
     * Get the Brand Collection
     *
     * @return \Magento\Framework\Data\Collection\AbstractDb|\Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection|null
     */
    public function getBrandCollection()
    {
        $brandModel = $this->brandFactory->create();
        return $brandModel->getCollection();
    }

    /**
     * Get the  customer group id
     *
     * @return int
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCustomerGroupId()
    {
        return $this->customerSession->getCustomerGroupId();
    }

    /**
     * Get the Store Id
     *
     * @return int
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getStoreId()
    {
        return $this->storeManager->getStore()->getId();
    }
}
