<?php

namespace Lava\FileProcessor\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Lava\FileProcessor\Block\Adminhtml\Module\Grid\Renderer\Action\UrlBuilder;
use Magento\Framework\UrlInterface;
use Lava\FileProcessor\Api\Data\FileInterface;

class Actions extends Column
{
    /** Url path */
    const URL_PATH_CANCEL = 'fileprocessor/file/cancel';

    /** @var UrlBuilder */
    protected $actionUrlBuilder;

    /** @var UrlInterface */
    protected $urlBuilder;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlBuilder $actionUrlBuilder
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlBuilder $actionUrlBuilder,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->actionUrlBuilder = $actionUrlBuilder;

        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');

                if (isset($item['entity_id'])) {
                    if (isset($item['status']) && $item['status'] == FileInterface::DEFAULT_FILE_STATUS) {
                        $item[$name]['cancel'] = [
                            'href' => $this->urlBuilder->getUrl(self::URL_PATH_CANCEL, ['entity_id' => $item['entity_id']]),
                            'label' => __('Cancel'),
                            'confirm' => [
                                'title' => __('Cancel'),
                                'message' => __('Are you sure you wan\'t to cancel file task with id "${ $.$data.entity_id }" ?')
                            ]
                        ];
                    }
                }
            }
        }

        return $dataSource;
    }

}
