<?php
/**
 * Do not edit or add to this file if you wish to upgrade to newer versions in the future.
 * If you wish to customise this module for your needs.
 *
 * @package    Itonomy_AdminActivity
 * @copyright  Copyright (C) 2018 Kiwi Commerce Ltd (https://kiwicommerce.co.uk/)
 * @copyright  Copyright (C) 2021 Itonomy B.V. (https://www.itonomy.nl)
 * @license    https://opensource.org/licenses/OSL-3.0
 */
namespace Itonomy\AdminActivity\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Class Benchmark
 * @package Itonomy\AdminActivity\Helper
 */
class Benchmark extends AbstractHelper
{

    /**
     * Get Benchmark is enable or not
     */
    const BENCHMARK_ENABLE = 1;

    /**
     * @var \Itonomy\AdminActivity\Logger\Logger
     */
    public $logger;

    /**
     * @var String[] Start time of execution
     */
    public $startTime;

    /**
     * @var String[] End time of execution
     */
    public $endTime;

    /**
     * @var Data
     */
    private $dataHelper;

    /**
     * Benchmark constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Itonomy\AdminActivity\Logger\Logger $logger
     * @param \Itonomy\AdminActivity\Helper\Data $dataHelper
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Itonomy\AdminActivity\Logger\Logger $logger,
        \Itonomy\AdminActivity\Helper\Data $dataHelper
    ) {
        $this->dataHelper = $dataHelper;
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * log info about start time in millisecond
     * @param $method
     * @return void
     */
    public function start($method)
    {
        if (!$this->dataHelper->isDebuggingEnabled()) {
            return;
        }
        $this->reset($method);
        if (self::BENCHMARK_ENABLE) {
            $this->startTime[$method] = round(microtime(true) * 1000);
            $this->logger->info("Method: ". $method);
            $this->logger->info("Start time: ". $this->startTime[$method]);
            \Magento\Framework\Profiler::start($method);
        }
    }

    /**
     * log info about end time and time diiference in millisecond
     * @param $method
     * @return void
     */
    public function end($method)
    {
        if (!$this->dataHelper->isDebuggingEnabled()) {
            return;
        }
        if (self::BENCHMARK_ENABLE) {
            $this->endTime[$method] = round(microtime(true) * 1000);
            $difference = $this->endTime[$method] - $this->startTime[$method];
            if ($difference) {
                $this->logger->info("Method: ". $method);
                $this->logger->info("Ends time: ". $this->endTime[$method]);
                $this->logger->info("Time difference in millisecond: ". $difference);
            }
            \Magento\Framework\Profiler::stop($method);
        }
    }

    /**
     * Reset start time and end time
     * @param $method
     * @return void
     */
    public function reset($method)
    {
        $this->startTime[$method] = 0;
        $this->endTime[$method] = 0;
    }
}
