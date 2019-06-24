<?php
declare(strict_types=1);

namespace Yireo\ExampleDealersAdminhtml\Controller\Adminhtml\Dealer;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\Message\Manager;
use Magento\Framework\View\Result\PageFactory;
use Yireo\ExampleDealers\Api\DealerRepositoryInterface;

/**
 * Save action.
 */
class Save extends Action
{
    const ADMIN_RESOURCE = 'Yireo_ExampleDealersAdminhtml::dealers';

    /**
     * @var RedirectFactory
     */
    private $redirectFactory;
    /**
     * @var DealerRepositoryInterface
     */
    private $dealerRepository;
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * Index constructor.
     * @param Context $context
     * @param RedirectFactory $redirectFactory
     * @param Manager $messageManager
     * @param DealerRepositoryInterface $dealerRepository
     * @param RequestInterface $request
     */
    public function __construct(
        Context $context,
        RedirectFactory $redirectFactory,
        Manager $messageManager,
        DealerRepositoryInterface $dealerRepository,
        RequestInterface $request
    ) {
        parent::__construct($context);
        $this->redirectFactory = $redirectFactory;
        $this->messageManager = $messageManager;
        $this->dealerRepository = $dealerRepository;
        $this->request = $request;
    }

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        $id = (int)$this->request->getParam('id');
        $name = (string)$this->request->getParam('name');
        $address = (string)$this->request->getParam('address');

        if ($this->isValidEntityId($id)) {
            $dealer = $this->dealerRepository->getById($id);
            $dealer->setName($name);
            $dealer->setAddress($address);
            $this->dealerRepository->save($dealer);
            $this->messageManager->addSuccessMessage('Saved entity successfully');
        } else {
            $this->messageManager->addErrorMessage('Invalid ID');
        }

        $redirect = $this->redirectFactory->create([]);
        $redirect->setPath('*/index/index');
        return $redirect;
    }

    /**
     * @param int $id
     * @return bool
     */
    private function isValidEntityId(int $id): bool
    {
        if (!$id > 0) {
            return false;
        }

        try {
            $dealer = $this->dealerRepository->getById($id);
        } catch (NotFoundException $exception) {
            return false;
        }

        if (!$dealer->getId() > 0) {
            return false;
        }

        return true;
    }
}
