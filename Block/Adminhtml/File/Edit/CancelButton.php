<?php

namespace Lava\FileProcessor\Block\Adminhtml\File\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class CancelButton
 */
class CancelButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Cancel'),
            'on_click' => sprintf("location.href = '%s';", $this->getCancelUrl()),
            'class' => 'delete disabled',
            'sort_order' => 10
        ];
    }

    /**
     * Get URL for back (reset) button
     *
     * @return string
     */
    public function getCancelUrl()
    {
        return $this->getUrl('*/*/cancel', ['entity_id' => $this->getId()]);
    }
}
