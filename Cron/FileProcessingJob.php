<?php

declare(strict_types=1);

namespace Lava\FileProcessor\Cron;

use Lava\FileProcessor\Model\ProcessorList;
use Lava\FileProcessor\Api\FileRepositoryInterface;
use Lava\FileProcessor\Api\Data\FileInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Psr\Log\LoggerInterface;

/**
 * FileProcessingJob
 */
class FileProcessingJob
{
    const DEFAULT_NUM_OF_FILES_TO_PROCESS = 1;

    /**;
     * @var ProcessorList
     */
    private $processorList;

    /**
     * @var FileRepositoryInterface
     */
    private $fileRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var SortOrderBuilder
     */
    private $sortOrderBuilder;

    /**
     * @var int
     */
    private $numOfFilesToProcess;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * FileProcessingJob constructor.
     * @param ProcessorList $processorList
     * @param FileRepositoryInterface $fileRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     * @param LoggerInterface $logger
     * @param null $numOfFilesToProcess
     */
    public function __construct(
        ProcessorList $processorList,
        FileRepositoryInterface $fileRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder,
        LoggerInterface $logger,
        $numOfFilesToProcess = null
    ){
        $this->logger = $logger;
        $this->processorList = $processorList;
        $this->fileRepository = $fileRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->numOfFilesToProcess = (int) $numOfFilesToProcess ? $numOfFilesToProcess : self::DEFAULT_NUM_OF_FILES_TO_PROCESS;
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function execute()
    {
        $file = $this->getNextFileInQueue();
        $timerStart = 0;

        if( is_null($file) ) {
            return; // @TODO Handle no files in the queue better then return;
        }

        try {
            $file->setStatus(FileInterface::PROCESSING_FILE_STATUS);
            $timerStart = time();
            $file->setTimestampUpdated($timerStart);
            $this->fileRepository->save($file);

            $processor = $this->processorList->getProcessor($file->getFileType());
            $file = $processor->process($file);

            $file->setStatus(FileInterface::COMPLETE_FILE_STATUS);
        } catch (\Exception $e) {
            $file->setStatus(FileInterface::ERROR_FILE_STATUS);
            $this->logger->error(__('Error during execution of file task "%1"', $e->getMessage()));
        }

        $timerEnd = time();
        $duration = $timerEnd - $timerStart;
        $file->setTimestampProcessed($timerEnd);
        $file->setDuration($duration);
        $this->fileRepository->save($file);
    }

    /**
     * Gets the next FileInterface in the queue. null if there is nothing in the queue.
     *
     * @return null|\Lava\FileProcessor\Api\Data\FileInterface
     */
    private function getNextFileInQueue()
    {
        $sortOrder = $this->sortOrderBuilder
            ->setField(FileInterface::ENTITY_ID)
            ->setDirection(\Lava\FileProcessor\Model\ResourceModel\File\Collection::SORT_ORDER_ASC)
            ->create();

        $searchCriteria = $this->searchCriteriaBuilder->setCurrentPage(1)->setPageSize(1)
            ->addSortOrder($sortOrder)
            ->addFilter(FileInterface::STATUS, FileInterface::DEFAULT_FILE_STATUS)
            ->create();

        $searchResult = $this->fileRepository->getList($searchCriteria);

        $items = $searchResult->getItems();
        $result = ( $searchResult->getTotalCount() ) ? array_shift($items) : null;

        return $result;
    }

}
