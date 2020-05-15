<?php

namespace Lava\FileProcessor\Model\ResourceModel\File;

/**
 * File Collection
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /** @var string $_idFieldName */
    protected $_idFieldName = \Lava\FileProcessor\Api\Data\FileInterface::ENTITY_ID;

    /** @var string $_eventPrefix */
    protected $_eventPrefix = 'lava_fileprocessor_file_collection';

    /** @var string $_eventObject */
    protected $_eventObject = 'file_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Lava\FileProcessor\Model\File::class,
            \Lava\FileProcessor\Model\ResourceModel\File::class
        );
    }
}
