<?php
namespace Phpingguo\CitronDI\Tests;

use Phpingguo\CitronDI\AuraDIWrapper;

class AuraDIWrapperTest extends \PHPUnit_Framework_TestCase
{
    public function providerGetClass()
    {
        return [
            [ 'tests', 'Phpingguo\CitronDI\Tests\MockDIWClass' ],
        ];
    }
    
    /**
     * @dataProvider providerGetClass
     */
    public function testGetClass($group_name, $class_name)
    {
        $group_path = realpath(__DIR__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config';
        $instance   = AuraDIWrapper::init($group_name, $group_path)->get($class_name);
        
        $this->assertInstanceOf($class_name, $instance);
        $this->assertSame("$class_name::getExecMethodName", $instance->getExecMethodName());
    }
}
