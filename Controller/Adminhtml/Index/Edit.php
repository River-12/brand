<?php

namespace Riverstone\ShopbyBrand\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Riverstone\ShopbyBrand\Model\ResourceModel\Brand;
use Riverstone\ShopbyBrand\Model\BrandFactory;

class Edit extends Action
{
    /**
     * @var resultPage
     */
    protected $resultPage;

    /**
     * @var bool|PageFactory
     */
    protected $resultPageFactory = false;

    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * @var BrandFactory
     */
    protected $model;

    /**
     * @var Brand
     */
    protected $resourceModel;

    /**
     * Edit constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Registry $coreRegistry
     * @param BrandFactory $model
     * @param Brand $resourceModel
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $coreRegistry,
        BrandFactory $model,
        Brand $resourceModel
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $coreRegistry;
        $this->model = $model;
        $this->resourceModel = $resourceModel;
    }

    /**
     * Execute function
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page|resultPage
     */
    public function execute()
    {
        $brandId = $this->getRequest()->getParam('id');
        $brand = $this->model->create();
        if ($brandId) {
            $this->resourceModel->load($brand, $brandId, "id");
            if ($brand->getId()) {
                $this->coreRegistry->register('brand', $brand);
            }
        }
        $resultPage = $this->getResultPage();
        $resultPage->getConfig()->getTitle()->prepend(
            $brand->getId() ? $brand->getBrandName() : __('New Brand')
        );
        return $resultPage;
    }

    /**
     * GetResultPage
     *
     * @return \Magento\Framework\View\Result\Page|resultPage
     */
    public function getResultPage()
    {
        $this->resultPage = $this->resultPageFactory->create();
        return $this->resultPage;
    }
}
