<?php
declare(strict_types=1);

namespace Yireo\ExampleDealersAdminhtml\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Index action.
 */
class Index extends Action
{
    const ADMIN_RESOURCE = 'Yireo_ExampleDealersAdminhtml::dealers';

    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * Index constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Yireo_ExampleDealersAdminhtml::index');
        $resultPage->addBreadcrumb(__('Dealers'), __('Dealers'));
        $resultPage->getConfig()->getTitle()->prepend(__('Dealers'));
        return $resultPage;
    }
}
