<?php

namespace Lava\FileProcessor\Model;

use Magento\Framework\Api\SortOrder;
use Lava\FileProcessor\Api\Data\FileInterface;

/**
 * Class FileRepository
 */
class FileRepository implements \Lava\FileProcessor\Api\FileRepositoryInterface
{
    /** @var \Lava\FileProcessor\Model\FileFactory $fileFactory */
    private $fileFactory;

    /** @var \Lava\FileProcessor\Model\FileSearchResultFactory $fileSearchResultFactory */
    private $fileSearchResultFactory;

    /** @var \Lava\FileProcessor\Model\ResourceModel\File\CollectionFactory $fileCollectionFactory */
    private $fileCollectionFactory;

    /**
     * FileRepository constructor.
     *
     * @param \Lava\FileProcessor\Model\FileFactory                          $fileFactory
     * @param \Lava\FileProcessor\Model\FileSearchResultFactory              $fileSearchResultFactory
     * @param \Lava\FileProcessor\Model\ResourceModel\File\CollectionFactory $fileCollectionFactory
     */
    public function __construct(
        \Lava\FileProcessor\Model\FileFactory $fileFactory,
        \Lava\FileProcessor\Model\FileSearchResultFactory $fileSearchResultFactory,
        \Lava\FileProcessor\Model\ResourceModel\File\CollectionFactory $fileCollectionFactory
    ) {
        $this->fileFactory = $fileFactory;
        $this->fileSearchResultFactory = $fileSearchResultFactory;
        $this->fileCollectionFactory = $fileCollectionFactory;
    }

    /**
     * @param \Lava\FileProcessor\Api\Data\FileInterface $file
     *
     * @return \Lava\FileProcessor\Api\Data\FileInterface
     */
    public function save(FileInterface $file) : FileInterface
    {
        $file->getResource()->save($file);

        return $file;
    }

    /**
     * @param \Lava\FileProcessor\Api\Data\FileInterface $file
     *
     * @return \Lava\FileProcessor\Api\Data\FileInterface
     * @throws \Lava\FileProcessor\Exception\FileTaskCancelException
     */
    public function cancel(FileInterface $file) : FileInterface
    {
        $currentFileStatus = $file->getStatus();

        if ( $currentFileStatus != FileInterface::DEFAULT_FILE_STATUS) {
            throw new \Lava\FileProcessor\Exception\FileTaskCancelException(
                __('File task with status  "%1" cannot be canceled', $currentFileStatus)
            );
        }

        return $this->save($file->setStatus(FileInterface::CANCELED_FILE_STATUS));
    }

    /**
     * @param int $id
     *
     * @return \Lava\FileProcessor\Api\Data\FileInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id) : FileInterface
    {
        $obj = $this->fileFactory->create();

        $obj->getResource()->load($obj, $id);

        if (! $obj->getId()) {
            $message =  __('Unable to find File Entity with ID "%1"', $id);
            throw new \Magento\Framework\Exception\NoSuchEntityException($message);
        }

        return $obj;
    }

    /**
     * @param int $id
     *
     * @return \Lava\FileProcessor\Api\Data\FileInterface
     * @throws \Lava\FileProcessor\Exception\FileTaskCancelException
     */
    public function cancelById($id) : FileInterface
    {
        $obj = $this->getById($id);

        return $this->cancel($obj);
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     *
     * @return \Lava\FileProcessor\Api\Data\FileSearchResultInterface
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    ) : \Lava\FileProcessor\Api\Data\FileSearchResultInterface {
        $collection = $this->fileCollectionFactory->create();
        $searchResults = $this->fileSearchResultFactory->create();

        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());

        return $this->buildSearchResult($searchCriteria, $collection, $searchResults);
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface              $searchCriteria
     * @param \Lava\FileProcessor\Model\ResourceModel\File\Collection $collection
     */
    public function addFiltersToCollection(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria,
        \Lava\FileProcessor\Model\ResourceModel\File\Collection $collection
    ) {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];

            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }

            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface              $searchCriteria
     * @param \Lava\FileProcessor\Model\ResourceModel\File\Collection $collection
     */
    public function addSortOrdersToCollection(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria,
        \Lava\FileProcessor\Model\ResourceModel\File\Collection $collection
    ) {
        foreach ((array) $searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface              $searchCriteria
     * @param \Lava\FileProcessor\Model\ResourceModel\File\Collection $collection
     */
    public function addPagingToCollection(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria,
        \Lava\FileProcessor\Model\ResourceModel\File\Collection $collection
    ) {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface              $searchCriteria
     * @param \Lava\FileProcessor\Model\ResourceModel\File\Collection $collection
     * @param \Lava\FileProcessor\Api\Data\FileSearchResultInterface  $searchResults
     *
     * @return \Lava\FileProcessor\Api\Data\FileSearchResultInterface
     */
    public function buildSearchResult(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria,
        \Lava\FileProcessor\Model\ResourceModel\File\Collection $collection,
        \Lava\FileProcessor\Api\Data\FileSearchResultInterface $searchResults
    ) {
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
