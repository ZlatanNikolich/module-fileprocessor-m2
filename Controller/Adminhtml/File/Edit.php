<?php

namespace Lava\FileProcessor\Controller\Adminhtml\File;

use Magento\Framework\Controller\ResultInterface;
use Lava\FileProcessor\Controller\Adminhtml\File;

/**
 * File Processor Listing Controller
 */
class Edit extends File
{
    const ADMIN_RESOURCE = 'Lava_FileProcessor::create_cancel_task';

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id', null);
        $title = 'New File';

        if ($id) {
            $title = 'Edit File';
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__($title)));

        return $resultPage;
    }
}
