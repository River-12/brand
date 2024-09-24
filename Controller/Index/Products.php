<?php

namespace Riverstone\ShopbyBrand\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Result\PageFactory;
use Psr\Log\LoggerInterface;
use Riverstone\ShopbyBrand\Model\BrandFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

class Products extends Action
{
    /**
     * @var JsonFactory
     */
    protected $jsonFactory;
    /**
     * @var PageFactory
     */
    protected $pageFactory;
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
     * Products constructor.
     *
     * @param Context $context
     * @param JsonFactory $jsonFactory
     * @param PageFactory $pageFactory
     * @param BrandFactory $brandFactory
     * @param CollectionFactory $pdtCollectionFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        PageFactory $pageFactory,
        BrandFactory $brandFactory,
        CollectionFactory $pdtCollectionFactory,
        LoggerInterface $logger
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->pageFactory = $pageFactory;
        $this->brandFactory = $brandFactory;
        $this->pdtCollectionFactory = $pdtCollectionFactory;
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * Execute
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $brandId = $this->getRequest()->getParam('brandId');
        $resultPage = $this->pageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Brand Details'));
        $resultPage->getLayout()->getBlock('product.details.block')->setBrandId($brandId);
        return $resultPage;
    }
}
