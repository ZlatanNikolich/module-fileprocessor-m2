<?php

namespace Lava\FileProcessor\Model\Config\Source\File;

/**
 * Source model for file processor type.
 */
class Type implements \Magento\Framework\Option\ArrayInterface
{
    const PROCESSORS_NOT_AVAILABLE_OPTION = 'No file processors registered';

    const CHOOSE_PROCESSOR_OPTION = 'Specify file processor type';

    /** @var \Lava\FileProcessor\Model\ProcessorList $processorList */
    private $processorList;

    /**
     * Type constructor.
     *
     * @param \Lava\FileProcessor\Model\ProcessorList $processorList
     */
    public function __construct(
        \Lava\FileProcessor\Model\ProcessorList $processorList
    ) {
        $this->processorList = $processorList;
    }

    /**
     * Get registered file processors as option array.
     *
     * @codeCoverageIgnore
     * @return array
     */
    public function toOptionArray()
    {
        $optionArray = [];

        foreach ($this->processorList->getProcessors() as $name => $processor) {
            $optionArray[] = [
                'value' => $name,
                'label' => $processor->getLabel()
            ];
        }

        $firstValueArray[] = [
            'value' => '',
            'label' => $this->getFirstValueLabel($optionArray)
        ];

        return array_merge($firstValueArray, $optionArray);
    }


    /**
     * Get the label for the first option in the array.
     *
     * @param array $optionArray
     * @return \Magento\Framework\Phrase
     */
    private function getFirstValueLabel($optionArray)
    {
        if( count($optionArray) > 0 ) {
            return __(self::CHOOSE_PROCESSOR_OPTION);
        }
        return  __(self::PROCESSORS_NOT_AVAILABLE_OPTION);
    }
}
