<?php

namespace IPLib;

/**
 * Factory methods to build class instances.
 */
class Factory
{
    /**
     * Parse an IP address string.
     *
     * @param string $address the address to parse
     * @param bool $mayIncludePort set to false to avoid parsing addresses with ports
     *
     * @return Address\AddressInterface|null
     */
    public static function addressFromString($address, $mayIncludePort = true)
    {
        $result = null;
        if ($result === null) {
            $result = Address\IPv4::fromString($address, $mayIncludePort);
        }
        if ($result === null) {
            $result = Address\IPv6::fromString($address, $mayIncludePort);
        }

        return $result;
    }

    /**
     * Convert a byte array to an address instance.
     *
     * @param int[]|array $bytes
     *
     * @return Address\AddressInterface|null
     */
    public static function addressFromBytes(array $bytes)
    {
        $result = null;
        if ($result === null) {
            $result = Address\IPv4::fromBytes($bytes);
        }
        if ($result === null) {
            $result = Address\IPv6::fromBytes($bytes);
        }

        return $result;
    }

    /**
     * Parse an IP range string.
     *
     * @param string $range
     *
     * @return Range\RangeInterface|null
     */
    public static function rangeFromString($range)
    {
        $result = null;
        if ($result === null) {
            $result = Range\Subnet::fromString($range);
        }
        if ($result === null) {
            $result = Range\Pattern::fromString($range);
        }
        if ($result === null) {
            $result = Range\Single::fromString($range);
        }

        return $result;
    }
}
