<?php

namespace Lava\FileProcessor\Controller\Adminhtml\File;

use Magento\Framework\Controller\ResultInterface;
use Lava\FileProcessor\Controller\Adminhtml\File;

/**
 * File Processor Listing Controller
 */
class NewAction extends File
{
    /**
     * @return ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/edit', array('_current' => true));
    }
}
