<?php
namespace Phpeel\CitronDI\Tests;

use Phpeel\CitronDI\DIPresetServices;
use Symfony\Component\Yaml\Parser;

class DIPresetServicesTest extends \PHPUnit_Framework_TestCase
{
    public function providerGetClass()
    {
        return [
            [ 'tests', 1, [ 'Phpeel\CitronDI\Tests\MockDIWClass' ] ],
        ];
    }

    /**
     * @dataProvider providerGetClass
     */
    public function testGetClass($group_name, $count, $expected)
    {
        $group_path = realpath(
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config'
        );
        $services   = DIPresetServices::get($group_name, $group_path);
        
        $this->assertNotEmpty($services);
        $this->assertCount($count, $services);
        $this->assertSame($expected, $services);
        
        $path  = $group_path . DIRECTORY_SEPARATOR . "{$group_name}_preset_services.yml";
        $value = is_file($path) ? (new Parser())->parse(file_get_contents($path)) : null;
        
        $this->assertSame($value, $services);
    }
}
