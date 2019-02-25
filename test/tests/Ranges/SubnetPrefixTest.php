<?php

namespace IPLib\Test\Ranges;

use IPLib\Range\Subnet;
use IPLib\Test\TestCase;

class SubnetPrefixTest extends TestCase
{
    public function ipProvider()
    {
        $tests = array();

        // IPv4.
        for ($i = 0; $i <= 32; $i++) {
            $test[] = array('0.0.0.0/'.$i, $i);
        }

        // IPv6.
        for ($i = 0; $i <= 128; $i++) {
            $test[] = array('0000:0000:0000:0000:0000:0000:0000:0000/128/'.$i, $i);
        }

        return $tests;
    }

    /**
     * @dataProvider ipProvider
     */
    public function testSubnetPrefix($rangeString, $expectedPrefix)
    {
        $range = Factory::rangeFromString($rangeString);
        $this->assertNotNull($range, "'$rangeString' has been detected as an invalid subnet, but it should be valid");
        $detectedPrefix = $range->getSubnetPrefix();
        $this->assertSame($expectedPrefix, $detectedPrefix, sprintf("'%s' has been detected prefix as\n%s\ninstead of\n%s", $detectedPrefix, $expectedPrefix));
    }
}
