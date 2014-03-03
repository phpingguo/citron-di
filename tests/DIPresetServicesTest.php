<?php
namespace Phpingguo\CitronDI\Tests;

use Phpingguo\CitronDI\DIPresetServices;

class DIPresetServicesTest extends \PHPUnit_Framework_TestCase
{
    public function providerGetClass()
    {
        return [
            [ 'tests', 1, [ 'Phpingguo\CitronDI\Tests\MockDIWClass' ] ],
        ];
    }

    /**
     * @dataProvider providerGetClass
     */
    public function testGetClass($group_name, $count, $expected)
    {
        $services = DIPresetServices::get($group_name);
        
        $this->assertNotEmpty($services);
        $this->assertCount($count, $services);
        $this->assertSame($expected, $services);
    }
}
