<?php

namespace Tests;

use \TypeIt\Store;

class StoreTest extends \Tests\TestCase
{

    public function testItShouldReturnVersionOfTypeIt() {
        $this->assertEquals(
            Store::get('typeit_version'),
            '8.0.3'
        );
    }

    public function testItShouldReturnOptionDefaultsFromFile() {
        $defaults = Store::get('option_defaults');
        $defaultsFromFile = require(realpath(dirname(__FILE__) . '/../src/default-options.php'));
        $this->assertSame($defaultsFromFile, $defaults);
    }

    public function testItShouldReturnOptionDefaultValues() {
        $defaults = Store::get('option_default_values');

        $this->assertEquals($defaults['strings'], '');
        $this->assertEquals($defaults['speed'], 100);
        $this->assertEquals($defaults['deletespeed'], null);
        $this->assertEquals($defaults['cursor'], true);
    }
}
