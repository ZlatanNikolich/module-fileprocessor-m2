<?php

namespace Lava\FileProcessor\Api;

/**
 * FileProcessor Interface
 *
 * @api
 * @since 1.0.0
 */
interface FileProcessorInterface
{
    /**
     * Method to process file.
     *
     * @param Data\FileInterface $file
     * @return bool
     */
    public function process(Data\FileInterface $file) : Data\FileInterface;

    /**
     * Returns human readable label
     *
     * @return string
     */
    public function getLabel();
}
