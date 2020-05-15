<?php

namespace Lava\FileProcessor\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Lava\FileProcessor\Api\Data\FileInterface;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists(FileInterface::ENTITY_MAIN_TABLE)) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable(FileInterface::ENTITY_MAIN_TABLE)
            )
                ->addColumn(
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true,
                    ],
                    'File Entity ID'
                )
                ->addColumn(
                    'file_location',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    1024,
                    ['nullable' => false],
                    'Relative file path to the processor/imports and processor/exports paths'
                )
                ->addColumn(
                    'file_type',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    1024,
                    ['nullable' => false],
                    'Class name for the ReaderInterface or WriterInterface'
                )
                ->addColumn(
                    'status',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    64,
                    [
                        'nullable' => false,
                        'default' => FileInterface::DEFAULT_FILE_STATUS
                    ],
                    'File status'
                )
                ->addColumn(
                    'timestamp_created',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    [
                        'nullable' => false,
                        'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT
                    ],
                    'File Entity Created Time'
                )
                ->addColumn(
                    'timestamp_updated',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    [
                        'nullable' => false,
                        'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE
                    ],
                    'File Entity Updated Time'
                )
                ->addColumn(
                    'timestamp_processed',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => true],
                    'Time of when the process completes'
                )
                ->addColumn(
                    'duration',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['nullable' => true],
                    'How long in milliseconds the process took to complete'
                )
                ->addColumn(
                    'success_count',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['nullable' => true],
                    'Count of successful tasks'
                )
                ->addColumn(
                    'error_count',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['nullable' => true],
                    'Count of failed tasks'
                )
                ->addColumn(
                    'total_count',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['nullable' => true],
                    'Count of total tasks processed (should be equal to success + error)'
                )
                ->setComment('File Entity Table');
            $installer->getConnection()->createTable($table);

            $installer->getConnection()->addIndex(
                $installer->getTable(FileInterface::ENTITY_MAIN_TABLE),
                $installer->getIdxName(
                    FileInterface::ENTITY_MAIN_TABLE,
                    [FileInterface::FILE_LOCATION, FileInterface::FILE_TYPE],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                [FileInterface::FILE_LOCATION, FileInterface::FILE_TYPE],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
            );
        }

        $installer->endSetup();
    }
}
