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

class Save extends Action
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
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $brandModel = $this->model->create();

            $brandModel->setData([
                'status' => $data['status'],
                'brand_name' => $data['brand_name'],
                'description' => $data['description'],
                'store' => json_encode($data['store']),
                'customer_group' => json_encode($data['customer_group']),
                'url_key' => $data['url_key'],
                'position' => $data['position'],
                'meta_title' => $data['meta_title'],
                'meta_description' => $data['meta_description'],
                'meta_keywords' => $data['meta_keywords']
            ]);

            if (isset($data["image"][0]["url"])) {
                $brandModel->setImage($data["image"][0]["url"]);
            }

            if (isset($data["banner_image"][0]["url"])) {
                $brandModel->setBannerImage($data["banner_image"][0]["url"]);
            }

            if (isset($data['id'])) {
                $brandModel->setId($data['id']);
            }

            try {
                $this->resourceModel->save($brandModel);
                $this->messageManager->addSuccessMessage(__('You saved the brand.'));

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath(
                        '*/*/edit',
                        ['id' => $brandModel->getId(), '_current' => true]
                    );
                }
                return $resultRedirect->setPath('*/*/index');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->dataPersistor->set('brand', $data);
                return $resultRedirect->setPath('*/*/edit', ['id' => $brandModel->getId()]);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Cannot save this brand. Try again.'));
                return $resultRedirect->setPath('*/*/index');
            }
        }

        return $resultRedirect->setPath('*/*/index');
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
