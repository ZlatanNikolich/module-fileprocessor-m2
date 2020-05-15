<?php

namespace Lava\FileProcessor\Controller\Adminhtml\File;

use Magento\Framework\Controller\ResultInterface;
use Lava\FileProcessor\Controller\Adminhtml\File;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Result\PageFactory;
use Lava\FileProcessor\Api\FileRepositoryInterface;
use Lava\FileProcessor\Model\FileFactory;
use Lava\FileProcessor\Model\FileUploader;
use Lava\FileProcessor\Api\Data\FileInterface;
use Lava\FileProcessor\Model\ProcessorList;
use Lava\FileProcessor\Model\AbstractReadFileProcessor;
use Lava\FileProcessor\Model\AbstractWriteFileProcessor;
use Magento\Framework\Serialize\Serializer\Json;

/**
 * File Processor Save file task Controller
 */
class Save extends File
{
    const ADMIN_RESOURCE = 'Lava_FileProcessor::create_cancel_task';

    /**
     * @var FileUploader
     */
    private $fileUploader;

    /**
     * @var ProcessorList
     */
    private $processorList;

    /**
     * @var Json
     */
    private $jsonSerializer;

    /**
     * Upload constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param FileRepositoryInterface $fileRepository
     * @param JsonFactory $resultJsonFactory
     * @param FileFactory $fileFactory
     * @param FileUploader $fileUploader
     * @param ProcessorList $processorList
     * @param Json $jsonSerializer
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        FileRepositoryInterface $fileRepository,
        JsonFactory $resultJsonFactory,
        FileFactory $fileFactory,
        FileUploader $fileUploader,
        ProcessorList $processorList,
        Json $jsonSerializer
    ) {
        parent::__construct($context, $resultPageFactory, $fileRepository, $resultJsonFactory, $fileFactory);

        $this->fileUploader = $fileUploader;
        $this->processorList = $processorList;
        $this->jsonSerializer = $jsonSerializer;
    }

    /**
     * @return ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $errorMsg = [];
        $redirectPath = '*/*/';

        if ($this->_formKeyValidator->validate($this->getRequest())) {
            $fileData = $this->getRequest()->getPost('lava_fileprocessor_file_edit');
            $registeredFileProcessors = $this->processorList->getProcessors();

            if (empty($registeredFileProcessors[$fileData[FileInterface::FILE_TYPE]])) {
                $errorMsg[] = __('No such file processor registered.');
                $redirectPath = '*/*/new';
            }

            if (empty($fileData[FileInterface::STATUS])) {
                unset($fileData[FileInterface::STATUS]);
            }

            try {
                $params = $this->jsonSerializer->unserialize($fileData[FileInterface::PARAMS]);
            } catch (\InvalidArgumentException $e) {
                $params = [];
            }

            unset($fileData[FileInterface::PARAMS]);

            $file = $this->initFileModel();
            $file->setData($fileData);
            $file->setParams($params);

            $this->_eventManager->dispatch(
                'lava_fileprocessor_file_prepare_save',
                [
                    'fileprocessor_file' => $file,
                    'request' => $this->getRequest()
                ]
            );

            try {
                $fileLocation = '';
                $fileProcessor = $registeredFileProcessors[$fileData[FileInterface::FILE_TYPE]];

                if (!empty($fileData[self::FILE_TO_UPLOAD_FORM_FIELD])) {

                    // if (!$fileProcessor instanceof AbstractReadFileProcessor) {
                    //     $errorMsg[] = __(
                    //         'File processor "%1" cannot be used for import tasks. Please specify a instance of %2',
                    //         get_class($fileProcessor),
                    //         AbstractReadFileProcessor::class
                    //     );
                    //     $redirectPath = '*/*/new';
                    // }

                    $subDir = date('mdY');
                    $basePath = FileInterface::BASE_IMPORT_PATH . DIRECTORY_SEPARATOR . $subDir;
                    $this->fileUploader->setBasePath($basePath);
                    $name = $fileData[self::FILE_TO_UPLOAD_FORM_FIELD][0]['name'];
                    $fileName = $this->fileUploader->moveFileFromTmp($name);
                    $fileLocation = $subDir . DIRECTORY_SEPARATOR . $fileName;
                }

                if (!empty($fileData[self::FILE_TO_EXPORT_FORM_FIELD])) {
                    // if (!$fileProcessor instanceof AbstractWriteFileProcessor) {
                    //     $errorMsg[] = __(
                    //         'File processor "%1" cannot be used for export tasks. Please specify a instance of %2',
                    //         get_class($fileProcessor),
                    //         AbstractWriteFileProcessor::class
                    //     );
                    //     $redirectPath = '*/*/new';
                    // }

                    $fileLocation = $fileData[self::FILE_TO_EXPORT_FORM_FIELD];
                }


                if (empty($fileLocation)) {
                    $errorMsg[] = __('File location cannot be empty');
                    $redirectPath = '*/*/new';
                }

                if (!empty($errorMsg)) {
                    throw new \Exception(implode(PHP_EOL, $errorMsg));
                }

                $file->setFileLocation($fileLocation);
                $file->setFileType($fileData[FileInterface::FILE_TYPE]);
                $this->fileRepository->save($file);
            } catch (\Exception $e) {
                $msg = !empty($errorMsg) ? $e->getMessage() : __('Something went wrong while saving the file task.');
                $this->messageManager->addExceptionMessage($e, $msg);
            }

            if (empty($errorMsg)) {
                $this->messageManager->addSuccessMessage(__('File task saved successfully.'));
            }
        }

        return $resultRedirect->setPath($redirectPath, array('_current' => true));
    }
}
