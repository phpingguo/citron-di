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
        $instance = AuraDIWrapper::init($group_name)->get($class_name);
        
        $this->assertInstanceOf($class_name, $instance);
        $this->assertSame("$class_name::getExecMethodName", $instance->getExecMethodName());
    }
}
