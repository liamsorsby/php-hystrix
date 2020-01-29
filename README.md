# php-hystrix 

[![Build Status](https://travis-ci.com/liamsorsby/php-hystrix.svg?branch=master)](https://travis-ci.com/liamsorsby/php-hystrix) [![codecov](https://codecov.io/gh/liamsorsby/php-hystrix/branch/master/graph/badge.svg)](https://codecov.io/gh/liamsorsby/php-hystrix) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/liamsorsby/php-hystrix/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/liamsorsby/php-hystrix/?branch=master) 
[![Build Status](https://scrutinizer-ci.com/g/liamsorsby/php-hystrix/badges/build.png?b=master)](https://scrutinizer-ci.com/g/liamsorsby/php-hystrix/build-status/master) [![Code Intelligence Status](https://scrutinizer-ci.com/g/liamsorsby/php-hystrix/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)

## Circuit Breaker
This is an example repo that provides basic circuit breaking capabilities

## Supported Caches
1. APC
2. RedisCluster

## Examples

```php
$cb = $factory->create(StorageFactory::APC, []);

try {
    if(!$cb->isOpen()) {
        // do something
        return;
    }
    // Transactional or complex operation
} catch (Exception $e) {
    $cb->reportFailure('');
    // log error from $e->getMessage()
}
```
