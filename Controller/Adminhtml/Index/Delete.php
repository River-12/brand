<?php

namespace Riverstone\ShopbyBrand\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Riverstone\ShopbyBrand\Model\ResourceModel\Brand;
use Riverstone\ShopbyBrand\Model\BrandFactory;

class Delete extends Action
{
    /**
     * PageFactory config
     *
     * @var PageFactory
     */
    protected $resultPage;

    /**
     * @var bool|PageFactory
     */
    protected $resultPageFactory = false;
    /**
     * Registry value
     *
     * @var Registry
     */
    protected $coreRegistry;
    /**
     * BrandModel Factory
     *
     * @var BrandFactory
     */
    protected $model;
    /**
     * Brand ResourceModel
     *
     * @var Brand
     */
    protected $resourceModel;

    /**
     * Constructor parameter
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
     * @return ResponseInterface|ResultInterface|Page|PageFactory
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $brandId = $this->getRequest()->getParam('id');
        try {
            if ($brandId) {
                $brandModel = $this->model->create();
                $brandModel->load($brandId);
                $brandModel->delete();
                $this->messageManager->addSuccessMessage(__('You deleted the brand.'));
            }
            return $resultRedirect->setPath('*/*/index');
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return $resultRedirect->setPath('*/*/edit', ['id' => $brandModel->getId()]);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Cannot delete this brand. Try again.'));
            return $resultRedirect->setPath('*/*/index');
        }
    }

    /**
     * Resource allow
     *
     * @return bool
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(static::ADMIN_RESOURCE);
    }
}
