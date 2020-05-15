<?php

declare(strict_types=1);

namespace Lava\FileProcessor\Controller\Adminhtml;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;
use Lava\FileProcessor\Api\Data\FileInterface;
use Lava\FileProcessor\Api\FileRepositoryInterface;
use Lava\FileProcessor\Model\FileFactory;

/**
 * File Processor Listing Controller
 */
abstract class File extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Lava_FileProcessor::main';

    const FILE_TO_UPLOAD_FORM_FIELD = 'file_location_read';

    const FILE_TO_EXPORT_FORM_FIELD = 'file_location_write';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var FileRepositoryInterface
     */
    protected $fileRepository;

    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var FileFactory
     */
    private $fileFactory;

    /**
     * Index constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param FileRepositoryInterface $fileRepository
     * @param JsonFactory $resultJsonFactory
     * @param FileFactory $fileFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        FileRepositoryInterface $fileRepository,
        JsonFactory $resultJsonFactory,
        FileFactory $fileFactory
    ) {
        parent::__construct($context);

        $this->resultPageFactory = $resultPageFactory;
        $this->fileRepository = $fileRepository;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->fileFactory = $fileFactory;
    }

    /**
     * @return bool|false|FileInterface
     */
    protected function initFileModel()
    {
        $fileId  = (int) $this->getRequest()->getParam('id', 0);

        if (!$fileId) {
            $result = $this->fileFactory->create();
        } else {
            try {
                $result = $this->fileRepository->getById($fileId);
            } catch (NoSuchEntityException $exception) {
                $result = false;
            }
        }

        return $result;
    }
}
