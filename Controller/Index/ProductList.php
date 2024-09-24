<?php

namespace Riverstone\ShopbyBrand\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Riverstone\ShopbyBrand\Model\BrandFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Psr\Log\LoggerInterface;

class ProductList extends Action
{
    /**
     * @var JsonFactory
     */
    protected $jsonFactory;
    /**
     * @var BrandFactory
     */
    protected $brandFactory;
    /**
     * @var CollectionFactory
     */
    protected $pdtCollectionFactory;
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * ProductList constructor.
     *
     * @param Context $context
     * @param JsonFactory $jsonFactory
     * @param BrandFactory $brandFactory
     * @param CollectionFactory $pdtCollectionFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        BrandFactory $brandFactory,
        CollectionFactory $pdtCollectionFactory,
        LoggerInterface $logger
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->brandFactory = $brandFactory;
        $this->pdtCollectionFactory = $pdtCollectionFactory;
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * Execute
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $result = $this->jsonFactory->create();
        $brandId = $this->getRequest()->getParam('brandId');
        // Fetch the product collection
        $collection = $this->pdtCollectionFactory->create();
        $collection->addAttributeToSelect('*')
                   ->addAttributeToFilter('brand_name', ['eq' => $brandId]);
        $result->setData([
            'success' => true,
            'products' => $collection->toArray()
        ]);
        return $result;
    }
}
