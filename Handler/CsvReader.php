<?php

namespace Lava\FileProcessor\Handler;

/**
 * Class CsvReader
 */
class CsvReader
{
    /**
     * @var string
    */
    protected $basePath;

    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $filesystem;

    /**
     * Class Constructor
     *
     * @param \Magento\Framework\Filesystem $filesystem
     * @param string $basePath
     */
    public function __construct(
        \Magento\Framework\Filesystem $filesystem,
        $basePath = 'processor/imports'
    ) {
        $this->basePath = $basePath;
        $this->filesystem = $filesystem;
    }

    /**
     * Tesst csv file handling.
     *
     * @param \Lava\FileProcessor\Api\Data\FileInterface $file
     * @param $processRowCallback
     * @param null $validateHeaderCallback
     *
     * @throws \Exception
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function handle(
        \Lava\FileProcessor\Api\Data\FileInterface $file,
        $processRowCallback,
        $validateHeaderCallback = null
    ) {
        if( !$file->getId() ) {
            throw new \Magento\Framework\Exception\NoSuchEntityException();
        }

        $fileLocation = $this->getAbsoluteFileLocation($file);

        if( !file_exists($fileLocation) ) {
            throw new \Exception('File "' . $file->getFileLocation() . '" does not exist');
        }

        $handle = fopen($fileLocation, 'r');
        $count = 0;
        while( $rowData = fgetcsv($handle) ) {
            if( $count === 0 ) {
                if( is_callable($validateHeaderCallback) ) {
                    $file = $validateHeaderCallback($file, $rowData);
                }
            } else {
                if( is_callable($processRowCallback) ) {
                    $file = $processRowCallback($file, $rowData);
                }
            }
            $count++;
        }
        fclose($handle);
    }

    /**
     * Prepare absolute file path
     *
     * @param \Lava\FileProcessor\Api\Data\FileInterface $file
     * @return string
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    protected function getAbsoluteFileLocation(\Lava\FileProcessor\Api\Data\FileInterface $file)
    {
        $mediaDirectory = $this->filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        $path = $mediaDirectory->getAbsolutePath($this->basePath);
        $fileLocation = $path . DIRECTORY_SEPARATOR . $file->getFileLocation();

        return $fileLocation;
    }
}
