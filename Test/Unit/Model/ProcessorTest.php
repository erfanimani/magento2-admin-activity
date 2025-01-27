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
namespace Itonomy\AdminActivity\Test\Unit\Model;

/**
 * Class ProcessorTest
 * @package Itonomy\AdminActivity\Test\Unit\Model
 */
class ProcessorTest extends \PHPUnit\Framework\TestCase
{
    public $configMock;

    public $actionName = '';

    public $fullActionName = 'catalog_product_save';

    public $observerMock;

    public $handlerMock;

    public $getEvent;

    public $lastAction = '';

    public $moduleName = 'module_name';

    public $eventConfig = ['action' => 'save', 'module' => 'catalog_products'];
    /**
     * @requires PHP 7.0
     */
    public function setUp()
    {
        $this->configMock = $this->getMockBuilder(\Itonomy\AdminActivity\Model\Config::class)
            ->setMethods(['getEventByAction','getTrackFieldModel','getEventModel','getActivityModuleConstant'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->sessionMock = $this->getMockBuilder(\Magento\Backend\Model\Auth\Session::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->handlerMock = $this->getMockBuilder(\Itonomy\AdminActivity\Model\Handler::class)
            ->setMethods(['request'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->observerMock = $this->getMockBuilder(\Magento\Framework\Event\Observer::class)
            ->setMethods(['getId','getEvent'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventMock = $this
            ->getMockBuilder(\Magento\Framework\Event::class)
            ->setMethods(['getObject'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->objectMock = $this
            ->getMockBuilder(\Magento\Framework\DataObject::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->remoteAddressMock = $this->getMockBuilder(\Magento\Framework\HTTP\PhpEnvironment\RemoteAddress::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->activityFactoryMock = $this->getMockBuilder(\Itonomy\AdminActivity\Model\ActivityFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->activityLogDetailFactoryMock = $this->getMockBuilder(\Itonomy\AdminActivity\Model\ActivityLogDetailFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeManagerInterfaceMock = $this->getMockBuilder(\Magento\Store\Model\StoreManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->dateTimeMock = $this->getMockBuilder(\Magento\Framework\Stdlib\DateTime\DateTime::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->activityRepositoryInterfaceMock = $this->getMockBuilder(\Itonomy\AdminActivity\Api\ActivityRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->dataMock = $this->getMockBuilder(\Itonomy\AdminActivity\Helper\Data::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->managerInterfaceMock = $this->getMockBuilder(\Magento\Framework\Message\ManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->requestInterfaceMock = $this->getMockBuilder(\Magento\Framework\App\RequestInterface::class)
            ->setMethods(['getModuleName',
                'getControllerName',
                'setModuleName',
                'getActionName',
                'setActionName',
                'getParam',
                'getParams',
                'getCookie',
                'setParams',
                'isSecure'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->statusMock = $this->getMockBuilder(\Itonomy\AdminActivity\Model\Activity\Status::class)
            ->disableOriginalConstructor()
            ->getMock();

        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);

        $this->processorTest = $objectManager->getObject(
            \Itonomy\AdminActivity\Model\Processor::class,
            [
                'config' => $this->configMock,
                'authSession' => $this->sessionMock,
                'handler' => $this->handlerMock,
                'remoteAddress' => $this->remoteAddressMock,
                'activityFactory' => $this->activityFactoryMock,
                'activityDetailFactory' => $this->activityLogDetailFactoryMock,
                'storeManager' => $this->storeManagerInterfaceMock,
                'dateTime' => $this->dateTimeMock,
                'activityRepository' => $this->activityRepositoryInterfaceMock,
                'helper' => $this->dataMock,
                'messageManager' => $this->managerInterfaceMock,
                'request' => $this->requestInterfaceMock,
                'status' => $this->statusMock
            ]
        );
    }

    public function testValidate()
    {

        $this->observerMock
            ->expects($this->any())
            ->method('getEvent')
            ->willReturnSelf();

        $this->dataMock
            ->expects($this->any())
            ->method('isWildCardModel')
            ->with($this->observerMock)
            ->willReturn(false);

        $this->configMock
            ->expects($this->any())
            ->method('getEventByAction')
            ->with('catalog_product_save')
            ->willReturn($this->eventConfig);

    }
}
