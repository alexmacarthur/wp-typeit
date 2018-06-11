<?php

namespace Tests;

use \TypeIt\Utilities;

class UtilitiesTest extends \Tests\TestCase
{
    private $options;

    public function setUp() {
        $this->options = [
            "strings" => ["a sample string"],
            "speed" => "100",
            "deleteSpeed" => "500",
            "lifeLike" => "true",
            "cursor" => "false",
            "cursorSpeed" => "100",
            "breakLines" => "false",
            "nextStringDelay" => "1",
            "startDelete" => "true",
            "startDelay" => "10",
            "loop" => "on",
            "loopDelay" => 1999,
            "html" => false
        ];
    }

    public function testEachOptionShouldHaveCorrectType()
    {
        $typed = Utilities::get_typed_options($this->options);

        $this->assertInternalType('array', $typed["strings"]);
        $this->assertInternalType('int', $typed["speed"]);
        $this->assertInternalType('int', $typed["deleteSpeed"]);
        $this->assertInternalType('bool', $typed["lifeLike"]);
        $this->assertInternalType('bool', $typed["cursor"]);
        $this->assertInternalType('int', $typed["cursorSpeed"]);
        $this->assertInternalType('bool', $typed["breakLines"]);
        $this->assertInternalType('int', $typed["nextStringDelay"]);
        $this->assertInternalType('bool', $typed["startDelete"]);
        $this->assertInternalType('int', $typed["startDelay"]);
        $this->assertInternalType('bool', $typed["loop"]);
        $this->assertInternalType('int', $typed["loopDelay"]);
        $this->assertInternalType('bool', $typed["html"]);
    }
}
