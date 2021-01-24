<?php

namespace IPLib\Test\Ranges;

use IPLib\Factory;
use IPLib\Test\TestCase;

class AddressAtOffsetTest extends TestCase
{
    public function ipProvider()
    {
        return array(
            array('127.0.0.0/16', 256, '127.0.1.0'),
            array('127.0.1.0/16', -1, '127.0.255.255'),
            array('127.0.0.0/24', 256, null),
        );
    }

    /**
     * @dataProvider ipProvider
     *
     * @param string $rangeString
     * @param int $n
     * @param string|null $expected
     */
    public function testAddressAtOffset($rangeString, $n, $expected)
    {
        $range = Factory::rangeFromString($rangeString);

        $result = $range->getAddressAtOffset($n);
        if ($result !== null) {
            $result = $result->toString();
        }

        $expectedString = $expected;
        if ($expected === null) {
            $expectedString = 'NULL';
        }

        $this->assertSame($expected, $result, "'{$rangeString}' with offset {$n} must be '{$expectedString}'");
    }
}
