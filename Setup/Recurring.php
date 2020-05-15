<?php

namespace Lava\FileProcessor\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Lava\FileProcessor\Api\Data\FileInterface;

/**
 * Class Recurring
 * @package Lava\FileProcessor\Setup
 */
class Recurring implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if ($setup->tableExists(FileInterface::ENTITY_MAIN_TABLE)) {
            $tableName = $setup->getTable(FileInterface::ENTITY_MAIN_TABLE);
            $connection = $setup->getConnection();

            if ($connection->tableColumnExists($tableName, FileInterface::PARAMS) === false) {
                $connection->addColumn($tableName,  FileInterface::PARAMS,
                    [
                        'type' =>  \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => false,
                        'length' => 255,
                        'default' => '',
                        'comment'   => 'JSON string with additional data for file processor.'
                    ]
                );
            }
        }

        $setup->endSetup();
    }
}
