<?php
declare(strict_types=1);

namespace Yireo\ExampleDealersAdminhtml\Model\ResourceModel\Dealer\Grid;

use Magento\Framework\Api\ExtensibleDataInterface;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Api\Search\AggregationInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Data\Collection as DataCollection;
use Magento\Framework\View\Element\UiComponent\DataProvider\Document;
use Yireo\ExampleDealers\Api\Data\DealerInterface;
use Yireo\ExampleDealers\Api\Data\DealerCollectionInterface as OriginalCollection;

/**
 * Class Collection
 * Collection for displaying grid of sales documents
 */
class Collection extends DataCollection implements SearchResultInterface
{
    /**
     * @var OriginalCollection
     */
    private $originalCollection;

    /**
     * @var AggregationInterface
     */
    protected $aggregations;

    /**
     * Collection constructor.
     * @param OriginalCollection $originalCollection
     */
    public function __construct(
        OriginalCollection $originalCollection,
        Document $model
    ) {
        $this->originalCollection = $originalCollection;
        $this->originalCollection->setModel(get_class($model));
    }

    /**
     * @return AggregationInterface
     */
    public function getAggregations()
    {
        return $this->aggregations;
    }

    /**
     * @param AggregationInterface $aggregations
     * @return $this
     */
    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
        return $this;
    }

    /**
     * Get search criteria.
     *
     * @return SearchCriteriaInterface|null
     */
    public function getSearchCriteria()
    {
        return null;
    }

    /**
     * Set search criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }

    /**
     * Get total count.
     *
     * @return int
     */
    public function getTotalCount()
    {
        return $this->originalCollection->getSize();
    }

    /**
     * Set total count.
     *
     * @param int $totalCount
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setTotalCount($totalCount)
    {
        return $this;
    }

    /**
     * Set items list.
     *
     * @param ExtensibleDataInterface[] $items
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setItems(array $items = null)
    {
        return $this;
    }

    /**
     * @return DealerInterface[]
     */
    public function getItems()
    {
        return $this->originalCollection->getItems();
    }
}
