<?php

namespace Lava\FileProcessor\Controller\Adminhtml\File;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;
use Lava\FileProcessor\Api\FileRepositoryInterface;
use Lava\FileProcessor\Controller\Adminhtml\File;
use Lava\FileProcessor\Model\FileFactory;
use Lava\FileProcessor\Model\FileUploader;

/**
 * File Upload Controller
 */
class Upload extends File
{
    const ADMIN_RESOURCE = 'Lava_FileProcessor::create_cancel_task';

    /**
     * @var FileUploader
     */
    protected $fileUploader;

    /**
     * Upload constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param FileRepositoryInterface $fileRepository
     * @param JsonFactory $resultJsonFactory
     * @param FileFactory $fileFactory
     * @param FileUploader $fileUploader
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        FileRepositoryInterface $fileRepository,
        JsonFactory $resultJsonFactory,
        FileFactory $fileFactory,
        FileUploader $fileUploader
    ) {
        parent::__construct($context, $resultPageFactory, $fileRepository, $resultJsonFactory, $fileFactory);
        $this->fileUploader = $fileUploader;
    }

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        $fileId = $this->getRequest()->getParam('param_name', self::FILE_TO_UPLOAD_FORM_FIELD);

        try {
            $result = $this->fileUploader->saveFileToTmpDir($fileId);

            $result['cookie'] = [
                'name' => $this->_getSession()->getName(),
                'value' => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path' => $this->_getSession()->getCookiePath(),
                'domain' => $this->_getSession()->getCookieDomain()
            ];
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getTraceAsString()];
        }

        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
