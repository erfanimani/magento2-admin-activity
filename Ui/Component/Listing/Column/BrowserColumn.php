<?php
/**
 * Do not edit or add to this file if you wish to upgrade to newer versions in the future.
 * If you wish to customize this module for your needs.
 *
 * @package    Itonomy_AdminActivity
 * @copyright  Copyright (C) 2018 Kiwi Commerce Ltd (https://kiwicommerce.co.uk/)
 * @copyright  Copyright (C) 2021 Itonomy B.V. (https://www.itonomy.nl)
 * @license    https://opensource.org/licenses/OSL-3.0
 */
namespace Itonomy\AdminActivity\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class BrowserColumn
 * @package Itonomy\AdminActivity\Ui\Component\Listing\Column
 */
class BrowserColumn extends Column
{
    /**
     * @var \Itonomy\AdminActivity\Helper\Browser
     */
    public $browser;

    /**
     * BrowserColumn constructor.
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param \Itonomy\AdminActivity\Helper\Browser $browser
     * @param array $components
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Itonomy\AdminActivity\Helper\Browser $browser,
        array $components,
        array $data
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->browser = $browser;
    }

    /**
     * Get user agent data
     * @param $item
     * @return string
     */
    public function getAgent($item)
    {
        $this->browser->reset();
        $this->browser->setUserAgent($item['user_agent']);
        return $this->browser->getBrowser().' '.$this->browser->getVersion();
    }

    /**
     * Prepare Data Source
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $item[$this->getData('name')] = $this->getAgent($item);
            }
        }
        return $dataSource;
    }
}
