[![Build Status](https://api.travis-ci.org/mlocati/ip-lib.svg?branch=master)](https://travis-ci.org/mlocati/ip-lib)
[![HHVM Status](http://hhvm.h4cc.de/badge/mlocati/ip-lib.svg?style=flat)](http://hhvm.h4cc.de/package/mlocati/ip-lib)
[![StyleCI Status](https://styleci.io/repos/54139375/shield)](https://styleci.io/repos/54139375)
[![Coverage Status](https://coveralls.io/repos/github/mlocati/ip-lib/badge.svg?branch=master)](https://coveralls.io/github/mlocati/ip-lib?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mlocati/ip-lib/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mlocati/ip-lib/?branch=master)

# IPLib - Handle IPv4, IPv6 and IP ranges


## Introduction

This library can handle IPv4, IPv6 addresses, as well as IP ranges, in CIDR formats (like `::1/128` or `127.0.0.1/32`) and in pattern format (like `::*:*` or `127.0.*.*`).


## Requirements

The only requirement is PHP 5.3.3.
__No external dependencies__ and __no special PHP configuration__ are needed (yes, it will __always work__ even if PHP has not been build with IPv6 support!).


## Manual installation

[Download](https://github.com/mlocati/ip-lib/releases) the latest version, unzip it and add these lines in our PHP files:

```php
require_once 'path/to/iplib/ip-lib.php';
```


## Installation with Composer

Simply run `composer install mlocati/ip-lib`, or add these lines to your `composer.json` file:

```json
"require": {
    "mlocati/ip-lib": "1.*"
}
```


## Sample usage


### Parse an address

To parse an IPv4 address:

```php
$address = \IPLib\Address\IPv4::fromString('127.0.0.1');
```

To parse an IPv6 address:

```php
$address = \IPLib\Address\IPv6::fromString('::1');
```

To parse an address in any format (IPv4 or IPv6):

```php
$address = \IPLib\Factory::addressFromString('::1');
$address = \IPLib\Factory::addressFromString('127.0.0.1');
```


### Parse an IP address range

To parse a subnet (CIDR) range:

```php
$range = \IPLib\Range\Subnet::fromString('127.0.0.1/24');
$range = \IPLib\Range\Subnet::fromString('::1/128');
```

To parse a pattern (asterisk notation) range:

```php
$range = \IPLib\Range\Pattern::fromString('127.0.0.*');
$range = \IPLib\Range\Pattern::fromString('::*');
```

To parse an andress as a range:

```php
$range = \IPLib\Range\Single::fromString('127.0.0.1');
$range = \IPLib\Range\Single::fromString('::1');
```

To parse a range in any format:

```php
$range = \IPLib\Factory::rangeFromString('127.0.0.*');
$range = \IPLib\Factory::rangeFromString('::1/128');
$range = \IPLib\Factory::rangeFromString('::');
```


### Format addresses and ranges

Both IP addresses and ranges have a `toString` method that you can use to retrieve a textual representation:
 
```php
echo \IPLib\Factory::addressFromString('127.0.0.1')->toString();
// prints 127.0.0.1
echo \IPLib\Factory::addressFromString('127.000.000.001')->toString();
// prints 127.0.0.1
echo \IPLib\Factory::addressFromString('::1')->toString();
// prints ::1
echo \IPLib\Factory::addressFromString('0:0::1')->toString();
// prints ::1
echo \IPLib\Factory::rangeFromString('0:0::1/64')->toString();
// prints ::1/64
```

When working with IPv6, you may want the full (expanded) representation of the addresses. In this case, simply use a `true` parameter for the `toString` method:

```php
echo \IPLib\Factory::addressFromString('::')->toString(true);
// prints 0000:0000:0000:0000:0000:0000:0000:0000
echo \IPLib\Factory::addressFromString('::1')->toString(true);
// prints 0000:0000:0000:0000:0000:0000:0000:0001
echo \IPLib\Factory::addressFromString('fff::')->toString(true);
// prints 0fff:0000:0000:0000:0000:0000:0000:0000
echo \IPLib\Factory::addressFromString('::0:0')->toString(true);
// prints 0000:0000:0000:0000:0000:0000:0000:0000
echo \IPLib\Factory::addressFromString('1:2:3:4:5:6:7:8')->toString(true);
// prints 0001:0002:0003:0004:0005:0006:0007:0008
echo \IPLib\Factory::rangeFromString('0:0::1/64')->toString();
// prints 0000:0000:0000:0000:0000:0000:0000:0001/64
```


### Check if an address is contained in a range

All the range types offer a `contains` method, and all the IP address types offer a `matches` method: you can call them to check if an address is contained in a range:

```php
$address = \IPLib\Factory::addressFromString('1:2:3:4:5:6:7:8');
$range = \IPLib\Factory::rangeFromString('0:0::1/64');

$contained = $address->matches($range);
// that's equivalent to
$contained = $range->contains($address);
```

Please remark that if the address is IPv4 and the range is IPv6 (or vice-versa), the result will always be `false`.
