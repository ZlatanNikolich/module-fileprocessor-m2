<?php

namespace  Lava\FileProcessor\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Lava\FileProcessor\Api\Data\FileInterface;

/**
 * File data model
 */
class File extends AbstractModel implements FileInterface, IdentityInterface
{
    /**
     * @var string
     */
    const CACHE_TAG = 'lava_file_processor_file';

    /**
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * @var string
     */
    protected $_eventPrefix = 'lava_file_processor_file';

    /**
     * Initialize resources
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\File::class);
    }

    /**
     * Get entity Id
     *
     * @return int
     */
    public function getId()
    {
        return $this->_getData(self::ENTITY_ID);
    }

    /**
     * Set entity Id
     *
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }

    /**
     * Get File location
     *
     * @return string|null
     */
    public function getFileLocation()
    {
        return $this->_getData(self::FILE_LOCATION);
    }

    /**
     * Set File location
     *
     * @param string $fileLocation
     * @return $this
     */
    public function setFileLocation($fileLocation)
    {
        return $this->setData(self::FILE_LOCATION, $fileLocation);
    }

    /**
     * Get File type
     *
     * @return string|null
     */
    public function getFileType()
    {
        return $this->_getData(self::FILE_TYPE);
    }

    /**
     * Set File type
     *
     * @param string $fileType
     * @return $this
     */
    public function setFileType($fileType)
    {
        return $this->setData(self::FILE_TYPE, $fileType);
    }

    /**
     * Get status
     *
     * @return string|null
     */
    public function getStatus()
    {
        return $this->_getData(self::STATUS);
    }

    /**
     * Set status
     *
     * @param string $status
     * @return $this
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Get created at timestamp
     *
     * @return int|null
     */
    public function getTimestampCreated()
    {
        return $this->_getData(self::TIMESTAMP_CREATED);
    }

    /**
     * Set created at timestamp
     *
     * @param int $timestampCreated
     * @return $this
     */
    public function setTimestampCreated($timestampCreated)
    {
        return $this->setData(self::TIMESTAMP_CREATED, $timestampCreated);
    }

    /**
     * Get updated at timestamp
     *
     * @return int|null
     */
    public function getTimestampUpdated()
    {
        return $this->_getData(self::TIMESTAMP_UPDATED);
    }

    /**
     * Set updated at timestamp
     *
     * @param int $timestampUpdated
     * @return $this
     */
    public function setTimestampUpdated($timestampUpdated)
    {
        return $this->setData(self::TIMESTAMP_UPDATED, $timestampUpdated);
    }

    /**
     * Get processed at timestamp
     *
     * @return int|null
     */
    public function getTimestampProcessed()
    {
        return $this->_getData(self::TIMESTAMP_PROCESSED);
    }

    /**
     * Set processed at timestamp
     *
     * @param int $timestampProcessed
     * @return $this
     */
    public function setTimestampProcessed($timestampProcessed)
    {
        return $this->setData(self::TIMESTAMP_PROCESSED, $timestampProcessed);
    }

    /**
     * Get duration of processing file
     *
     * @return int|null
     */
    public function getDuration()
    {
        return $this->_getData(self::DURATION);
    }

    /**
     * Set duration of processing file
     *
     * @param int $duration
     * @return $this
     */
    public function setDuration($duration)
    {
        return $this->setData(self::DURATION, $duration);
    }

    /**
     * Get success count
     *
     * @return int|null
     */
    public function getSuccessCount()
    {
        return $this->_getData(self::SUCCESS_COUNT);
    }

    /**
     * Set success count
     *
     * @param int $successCount
     * @return $this
     */
    public function setSuccessCount($successCount)
    {
        return $this->setData(self::SUCCESS_COUNT, $successCount);
    }

    /**
     * Get error count
     *
     * @return int|null
     */
    public function getErrorCount()
    {
        return $this->_getData(self::ERROR_COUNT);
    }

    /**
     * Set error count
     *
     * @param int $errorCount
     * @return $this
     */
    public function setErrorCount($errorCount)
    {
        return $this->setData(self::ERROR_COUNT, $errorCount);
    }

    /**
     * Get total count
     *
     * @return int|null
     */
    public function getTotalCount()
    {
        return $this->_getData(self::TOTAL_COUNT);
    }

    /**
     * Set total count
     *
     * @param int $totalCount
     * @return $this
     */
    public function setTotalCount($totalCount)
    {
        return $this->setData(self::TOTAL_COUNT, $totalCount);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get default values
     *
     * @return array
     */
    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }

    /**
     * Get params array.
     *
     * @return array
     */
    public function getParams()
    {
        $params = $this->_getData(self::PARAMS);

        return empty($params) ? [] : json_decode($params, true);
    }

    /**
     * Set params array.
     *
     * @param array $params
     * @return $this
     */
    public function setParams(array $params)
    {
        return $this->setData(self::PARAMS, json_encode($params));
    }
}
