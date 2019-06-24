<?php
declare(strict_types=1);

namespace Yireo\ExampleDealersAdminhtml\Model\Dealer;

use Magento\Ui\DataProvider\ModifierPoolDataProvider;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Yireo\ExampleDealers\Api\Data\DealerCollectionInterface;
use Yireo\ExampleDealers\Api\Data\DealerCollectionInterfaceFactory;

/**
 * Class DataProvider
 */
class DataProvider extends ModifierPoolDataProvider
{
    /**
     * @var DealerCollectionInterface
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
     * @param DealerCollectionInterfaceFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        DealerCollectionInterfaceFactory $collectionFactory,
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
