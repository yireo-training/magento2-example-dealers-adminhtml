<?php
declare(strict_types=1);

namespace Yireo\ExampleDealersAdminhtml\Model\Dealer;

use Magento\Ui\DataProvider\ModifierPoolDataProvider;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Yireo\ExampleDealers\Api\Data\DealerInterface;
use Yireo\ExampleDealers\Model\ResourceModel\Dealer\Collection;
use Yireo\ExampleDealers\Model\ResourceModel\Dealer\CollectionFactory;

/**
 * Class DataProvider
 */
class DataProvider extends ModifierPoolDataProvider
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var DealerInterface $dealer */
        foreach ($items as $dealer) {
            $this->loadedData[$dealer->getId()] = $dealer->getData();
        }

        $data = $this->dataPersistor->get('dealer');
        if (!empty($data)) {
            $dealer = $this->collection->getNewEmptyItem();
            $dealer->setData($data);
            $this->loadedData[$dealer->getId()] = $dealer->getData();
            $this->dataPersistor->clear('dealer');
        }

        return $this->loadedData;
    }
}
