<?php

namespace Lava\FileProcessor\Api\Data;

use Magento\Framework\Data\SearchResultInterface;

/**
 * FileSearchResult Interface
 *
 * @api
 * @since 1.0.0
 */
interface FileSearchResultInterface extends SearchResultInterface
{
    /**
     * Retrieve collection items
     *
     * @return FileInterface[]
     */
    public function getItems();

    /**
     * Set collection items
     *
     * @param FileInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}
