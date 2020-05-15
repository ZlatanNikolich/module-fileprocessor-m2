<?php

namespace Lava\FileProcessor\Controller\Adminhtml\File;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Lava\FileProcessor\Controller\Adminhtml\File;

/**
 * File Processor Listing Controller
 */
class Index extends File
{
    /**
     * @return ResponseInterface|ResultInterface|Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('File Processor Listing')));

        return $resultPage;
    }
}
