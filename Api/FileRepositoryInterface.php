<?php

namespace Lava\FileProcessor\Api;

use Lava\FileProcessor\Api\Data\{FileInterface, FileSearchResultInterface};
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * FileRepository Interface
 *
 * @api
 * @since 1.0.0
 */
interface FileRepositoryInterface
{
    /**
     * Save specified File entity.
     *
     * @param FileInterface $file
     * @return FileInterface $file
     */
    public function save(FileInterface $file) : FileInterface;

    /**
     * Cancel specified File task.
     *
     * @param FileInterface $file
     * @return FileInterface
     */
    public function cancel(FileInterface $file): FileInterface;

    /**
     * Retrieve list of items by criteria.
     *
     * @param SearchCriteriaInterface $criteria
     * @return FileSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $criteria) : FileSearchResultInterface;

    /**
     * Retrieve list of items by criteria.
     * @throws NoSuchEntityException
     * @param $id
     * @return FileInterface | false
     */
    public function getById($id) : FileInterface;

    /**
     * Cancel File task by id.
     *
     * @throws NoSuchEntityException
     * @param $id
     * @return mixed
     */
    public function cancelById($id) : FileInterface;
}
