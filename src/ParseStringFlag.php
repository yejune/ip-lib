<?php

namespace IPLib;

/**
 * Flags for the parseString() methods.
 *
 * @since 1.17.0
 */
class ParseStringFlag
{
    /**
     * Use this flag if the input string may include the port.
     *
     * @var int
     */
    const MAY_INCLUDE_PORT = 1;

    /**
     * Use this flag if the input string may include a zone ID.
     *
     * @var int
     */
    const MAY_INCLUDE_ZONEID = 2;

    /**
     * Use this flag if IPv4 addresses may be in decimal/octal/hexadecimal format.
     * This notation is accepted by the implementation of inet_aton and inet_addr of the libc implementation of GNU, Windows and Mac (but not Musl), but not by inet_pton and ip2long.
     *
     * @var int
     *
     * @example 1.08.0x10.0 => 5.0.0.1
     * @example 5.256 => 5.0.1.0
     * @example 5.0.256 => 5.0.1.0
     * @example 123456789 => 7.91.205.21
     */
    const IPV4_MAYBE_NON_DECIMAL = 4;

    /**
     * Use this flag if IPv4 addresses may be in non quad-dotted decimal notation.
     * This notation is accepted by the implementation of inet_aton and inet_addr of the libc implementation of GNU, Windows and Mac (but not Musl), but not by inet_pton and ip2long.
     *
     * @var int
     *
     * @example 5.1 => 5.0.0.1
     * @example 5.256 => 5.0.1.0
     * @example 5.0.256 => 5.0.1.0
     * @example 123456789 => 7.91.205.21
     *
     * @see https://man7.org/linux/man-pages/man3/inet_addr.3.html#DESCRIPTION
     * @see https://www.freebsd.org/cgi/man.cgi?query=inet_net&sektion=3&apropos=0&manpath=FreeBSD+12.2-RELEASE+and+Ports#end
     * @see http://git.musl-libc.org/cgit/musl/tree/src/network/inet_aton.c?h=v1.2.2
     */
    // @todo const IPV4ADDRESS_MAYBE_NON_QUAD_DOTTED = 8;

    /**
     * Use this flag if IPv4 addresses may be in non quad-dotted decimal notation.
     *
     * @example 127/24 => 127.0.0.0/24
     * @example 10/8 => 10.0.0.0/8
     * @example 10.10.10/24 => 10.10.10.0/24
     *
     * @var int
     */
    // @todo const IPV4SUBNET_MAYBE_COMPACT = 16;
}
