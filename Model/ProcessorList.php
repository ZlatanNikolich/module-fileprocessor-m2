<?php
declare(strict_types=1);

namespace Lava\FileProcessor\Model;

/**
 * Class ProcessorList
 */
class ProcessorList implements \Lava\FileProcessor\Api\ProcessorListInterface
{

    /**
     * @var \Lava\FileProcessor\Api\FileProcessorInterface[]
     */
    private $processors = [];

    /**
     * ProcessorList constructor.
     *
     * @param array $processors
     */
    public function __construct(
        array $processors = []
    ) {
        $this->processors = $processors;
    }

    /**
     * Method to get all registered file processors.
     *
     * @return \Lava\FileProcessor\Api\FileProcessorInterface[]
     */
    public function getProcessors() : array
    {
        return $this->processors;
    }

    /**
     * @param $name
     *
     * @return \Lava\FileProcessor\Api\FileProcessorInterface
     * @throws \Exception
     */
    public function getProcessor($name) : \Lava\FileProcessor\Api\FileProcessorInterface
    {
        if( ! isset($this->processors[$name]) ) {
            throw new \Exception($name . " is not a registered FileProcessor");
        }
        return $this->processors[$name];
    }
}
