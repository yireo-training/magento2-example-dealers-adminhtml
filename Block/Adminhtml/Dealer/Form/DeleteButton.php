<?php
declare(strict_types=1);

namespace Yireo\ExampleDealersAdminhtml\Block\Adminhtml\Dealer\Form;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Yireo\ExampleDealers\Api\DealerRepositoryInterface;

/**
 * Class DeleteButton
 */
class DeleteButton implements ButtonProviderInterface
{
    /**
     * @var UrlInterface
     */
    private $url;

    /**
     * @var DealerRepositoryInterface
     */
    private $dealerRepository;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * BackButton constructor.
     * @param UrlInterface $url
     * @param DealerRepositoryInterface $dealerRepository
     * @param RequestInterface $request
     */
    public function __construct(
        UrlInterface $url,
        DealerRepositoryInterface $dealerRepository,
        RequestInterface $request
    ) {
        $this->url = $url;
        $this->dealerRepository = $dealerRepository;
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function getButtonData()
    {
        $data = [];
        if ($this->getEntityId()) {
            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                        'Are you sure you want to do this?'
                    ) . '\', \'' . $this->getButtonUrl() . '\', {"data": {}})',
                'sort_order' => 20,
            ];
        }

        return $data;
    }

    /**
     * Get URL for back (reset) button
     *
     * @return string
     */
    private function getButtonUrl(): string
    {
        return (string)$this->url->getUrl('*/dealer/delete', ['id' => $this->getEntityId()]);
    }

    /**
     * @return int
     */
    private function getEntityId(): int
    {
        try {
            $id = (int)$this->request->getParam('id');
            return (int)$this->dealerRepository->getById($id)->getId();
        } catch (NoSuchEntityException $e) {
            return 0;
        }
    }
}
