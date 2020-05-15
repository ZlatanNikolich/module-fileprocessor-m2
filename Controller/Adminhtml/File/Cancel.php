<?php

namespace Lava\FileProcessor\Controller\Adminhtml\File;

use Magento\Framework\Controller\ResultInterface;
use Lava\FileProcessor\Controller\Adminhtml\File;

/**
 * File Processor Listing Controller
 */
class Cancel extends File
{
    const ADMIN_RESOURCE = 'Lava_FileProcessor::create_cancel_task';

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        $redirectResult = $this->resultRedirectFactory->create();
        $fileId = $this->getRequest()->getParam('entity_id', null);

        if (!$fileId) {
            $this->messageManager->addErrorMessage(__('Please specify file task!'));
            return $redirectResult->setRefererUrl();
        }

        try {
            $this->fileRepository->cancelById($fileId);
            $this->messageManager->addSuccessMessage(
                __('File Task with id %1  has been canceled successfully.', $fileId)
            );
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $redirectResult->setRefererUrl();
    }
}
