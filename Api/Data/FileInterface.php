<?php
declare(strict_types=1);

namespace Lava\FileProcessor\Api\Data;

/**
 * File Interface
 *
 * @api
 * @since 1.0.0
 */
interface FileInterface
{
    const ENTITY_MAIN_TABLE = 'lava_fileprocessor_file';

    const DEFAULT_FILE_STATUS = 'pending';

    const CANCELED_FILE_STATUS = 'cancelled';

    const PROCESSING_FILE_STATUS = 'processing';

    const COMPLETE_FILE_STATUS = 'complete';

    const ERROR_FILE_STATUS = 'error';

    const BASE_IMPORT_PATH = 'processor' . DIRECTORY_SEPARATOR . 'imports';

    const BASE_EXPORT_PATH = 'processor' . DIRECTORY_SEPARATOR . 'exports';

    /**#@+
     * Constants defined for keys of  data array
     */
    const ENTITY_ID = 'entity_id';

    const FILE_LOCATION = 'file_location';

    const FILE_TYPE = 'file_type';

    const STATUS = 'status';

    const TIMESTAMP_CREATED = 'timestamp_created';

    const TIMESTAMP_UPDATED = 'timestamp_updated';

    const TIMESTAMP_PROCESSED = 'timestamp_processed';

    const DURATION = 'duration';

    const SUCCESS_COUNT = 'success_count';

    const ERROR_COUNT = 'error_count';

    const TOTAL_COUNT = 'total_count';

    const PARAMS = 'params';

    /**#@-*/

    /**
     * Get File entity id
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set File entity id
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get File location
     *
     * @return string|null
     */
    public function getFileLocation();

    /**
     * Set File location
     *
     * @param string $fileLocation
     * @return $this
     */
    public function setFileLocation($fileLocation);

    /**
     * Get File type
     *
     * @return string|null
     */
    public function getFileType();

    /**
     * Set File type
     *
     * @param string $fileType
     * @return $this
     */
    public function setFileType($fileType);

    /**
     * Get status
     *
     * @return string|null
     */
    public function getStatus();

    /**
     * Set status
     *
     * @param string $status
     * @return $this
     */
    public function setStatus($status);

    /**
     * Get created at timestamp
     *
     * @return int|null
     */
    public function getTimestampCreated();

    /**
     * Set created at timestamp
     *
     * @param int $timestampCreated
     * @return $this
     */
    public function setTimestampCreated($timestampCreated);

    /**
     * Get updated at timestamp
     *
     * @return int|null
     */
    public function getTimestampUpdated();

    /**
     * Set updated at timestamp
     *
     * @param int $timestampUpdated
     * @return $this
     */
    public function setTimestampUpdated($timestampUpdated);

    /**
     * Get processed at timestamp
     *
     * @return int|null
     */
    public function getTimestampProcessed();

    /**
     * Set processed at timestamp
     *
     * @param int $timestampProcessed
     * @return $this
     */
    public function setTimestampProcessed($timestampProcessed);

    /**
     * Get duration of processing file
     *
     * @return int|null
     */
    public function getDuration();

    /**
     * Set duration of processing file
     *
     * @param int $duration
     * @return $this
     */
    public function setDuration($duration);

    /**
     * Get success count
     *
     * @return int|null
     */
    public function getSuccessCount();

    /**
     * Set success count
     *
     * @param int $successCount
     * @return $this
     */
    public function setSuccessCount($successCount);

    /**
     * Get error count
     *
     * @return int|null
     */
    public function getErrorCount();

    /**
     * Set error count
     *
     * @param int $errorCount
     * @return $this
     */
    public function setErrorCount($errorCount);

    /**
     * Get total count
     *
     * @return int|null
     */
    public function getTotalCount();

    /**
     * Set total count
     *
     * @param int $totalCount
     * @return $this
     */
    public function setTotalCount($totalCount);

    /**
     * Get params array.
     *
     * @return array
     */
    public function getParams();

    /**
     * Set params array.
     *
     * @param array $params
     * @return $this
     */
    public function setParams(array $params);
}
