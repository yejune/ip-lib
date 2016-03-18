<?php

use IPLib\Factory;

class MembershipTest extends PHPUnit_Framework_TestCase
{
    public function membershipProvider()
    {
        return array(
            array('0.0.0.0', '0.0.0.0', true),
            array('0.0.0.1', '0.0.0.0', false),
            array('127.0.0.0', '127.0.0.*', true),
            array('127.0.0.1', '127.0.0.*', true),
            array('127.0.0.255', '127.0.0.*', true),
            array('127.0.0.127', '127.0.1.*', false),
            array('127.0.0.0', '127.0.0.0/32', true),
            array('127.0.0.0', '127.0.0.255/24', true),
            array('127.0.0.0', '127.0.1.255/24', false),
            array('127.0.0.0', '127.0.1.255/16', true),
            array('::', '::', true),
            array('::1', '::', false),
            array('::1', '::*', true),
            array('::1:1', '::*', false),
            array('::1:1', '::1:*', true),
            array('::1:1', '::*:*', true),
            array('::1:1:1', '::*:*', false),
            array('::1:1:1', '::1:*:*', true),
            array('::', 'ffff::/128', false),
            array('::', 'ffff::/1', false),
            array('::', 'ffff::/0', true),
            array('::', '0.0.0.0', false),
            array('0.0.0.0', '::', false),
        );
    }

    /**
     * @dataProvider membershipProvider
     */
    public function testMembership($address, $range, $contained)
    {
        $addressStr = @strval($address);
        $rangeStr = @strval($range);

        $addressObject = Factory::addressFromString($address);
        $this->assertNotNull($addressObject, "'$addressStr' has not been recognized as an address");
        $this->assertInstanceOf('IPLib\Address\AddressInterface', $addressObject);

        $rangeObject = Factory::rangeFromString($range);
        $this->assertNotNull($rangeObject, "'$rangeStr' has not been recognized as a range");
        $this->assertInstanceOf('IPLib\Range\RangeInterface', $rangeObject);

        if ($contained) {
            $this->assertSame(true, $rangeObject->contains($addressObject), "Failed to check that '$rangeStr' contains '$addressStr'");
            $this->assertSame(true, $addressObject->matches($rangeObject), "Failed to check that '$addressStr' is contained in '$rangeStr'");
        } else {
            $this->assertSame(false, $rangeObject->contains($addressObject), "Failed to check that '$rangeStr' does not contain '$addressStr'");
            $this->assertSame(false, $addressObject->matches($rangeObject), "Failed to check that '$addressStr' is not contained in '$rangeStr'");
        }
    }
}
