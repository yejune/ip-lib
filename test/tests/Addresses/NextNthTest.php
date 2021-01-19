<?php

namespace IPLib\Test\Addresses;

use IPLib\Factory;
use IPLib\Test\TestCase;

class NextNthTest extends TestCase
{
    public function nextNthProvider()
    {
        return array(
            array('0.0.0.1', 500, '0.0.1.245'),
            array('0.0.0.2', -500, ''),
            array('1.2.3.4', 1024, '1.2.7.4'),
            array('1.2.3.0', -1024, '1.1.255.0'),
            array('1.255.255.253', 3, '2.0.0.0'),
            array('255.255.255.253', 3, ''),
            array('255.255.255.253', null, ''),
            array('::1', 65536, '::1:1'),
            array('::', -500, ''),
            array('::fffc', 3, '::ffff'),
            array('::ffff:ffff:ffff:0', -3, '::ffff:ffff:fffe:fffd'),
            array('::ffff:ffff:ffff:fffd', 3, '0:0:0:1::'),
            array('0:ffff:ffff:ffff:ffff:ffff:ffff:ffff', 3, '1::2'),
            array('ffff:ffff:ffff:ffff:ffff:ffff:ffff:fffd', 3, ''),
            array('ffff:ffff:ffff:ffff:ffff:ffff:ffff:fffd', null, ''),
        );
    }

    /**
     * @dataProvider nextNthProvider
     *
     * @param string $addressString
     * @param int $n
     * @param string $expected
     */
    public function testNextNth($addressString, $n, $expected)
    {
        $address = Factory::addressFromString($addressString);
        $this->assertInstanceof(
            'IPLib\Address\AddressInterface',
            $address,
            "Checking that {$addressString} is a valid address"
        );

        $next = $address->getNextNthAddress($n);

        $this->assertSame(
            $expected,
            (string) $next,
            "Checking the address {$addressString} " . ($n > 0 ? '+' : '-') . ' ' . abs($n)
        );

        if ($next !== null) {
            $this->assertSame(
                $addressString,
                (string) $next->getNextNthAddress(-$n),
                "Checking the address after the nth address before the nth {$addressString}"
            );
        }
    }
}
