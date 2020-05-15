<?php

namespace Lava\FileProcessor\Api;

/**
 * FileProcessor Interface
 *
 * @api
 * @since 1.0.0
 */
interface ProcessorListInterface
{
    /**
     * Method to get all registered file processors.
     *
     * @return FileProcessorInterface[]
     */
    public function getProcessors() : array;
}
