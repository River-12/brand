<?php

namespace Riverstone\ShopbyBrand\Controller\Adminhtml\MassAction;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Riverstone\ShopbyBrand\Model\ResourceModel\Brand;
use Riverstone\ShopbyBrand\Model\ResourceModel\Brand\CollectionFactory;
use Riverstone\ShopbyBrand\Model\BrandFactory;

class MassStatus extends Action
{

    /**
     * New filter
     *
     * @var Filter
     */
    protected $filter;
    /**
     * Model Slider
     *
     * @var BrandFactory
     */
    protected $model;
    /**
     * Resource Model Collection
     *
     * @var Brand
     */
    protected $resourceModel;
    /**
     * Brand Collection
     *
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * Constructor Params
     *
     * @param Context $context
     * @param Filter $filter
     * @param BrandFactory $model
     * @param Brand $resourceModel
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        BrandFactory $model,
        Brand $resourceModel,
        CollectionFactory $collectionFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->resourceModel = $resourceModel;
        $this->model = $model;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return Redirect
     * @throws LocalizedException|Exception
     */
    public function execute()
    {
        $statusValue = $this->getRequest()->getParam('status');
        $brand = $this->model->create();
        $collection = $this->filter->getCollection(
            $this->collectionFactory->create()
        );
        foreach ($collection as $item) {
            $brandId = $item->getId();
            $this->resourceModel->load($brand, $brandId, "id");
            $brand->setStatus($statusValue);
            $this->resourceModel->save($brand);
        }
        $this->messageManager->addSuccessMessage(
            __(
                'A total of %1 record(s) have been modified.',
                $collection->getSize()
            )
        );
        /**
         * @var Redirect $resultRedirect
         */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('brand/index/index');
    }
}
