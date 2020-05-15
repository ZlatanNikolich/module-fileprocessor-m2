<?php

namespace Lava\FileProcessor\Model\ResourceModel;

/**
 * Resource File Model
 */
class File extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(
            \Lava\FileProcessor\Api\Data\FileInterface::ENTITY_MAIN_TABLE,
            \Lava\FileProcessor\Api\Data\FileInterface::ENTITY_ID
        );
    }
}
