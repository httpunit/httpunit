HttpUnit
================

[![Build Status](https://travis-ci.org/httpunit/httpunit.svg?branch=master)](https://travis-ci.org/httpunit/httpunit)
[![Test Coverage](https://codeclimate.com/github/httpunit/httpunit/badges/coverage.svg)](https://codeclimate.com/github/httpunit/httpunit/coverage)
[![Code Climate](https://codeclimate.com/github/httpunit/httpunit/badges/gpa.svg)](https://codeclimate.com/github/httpunit/httpunit)

HttpUnit is a PHP library to crawl and test.

Features
--------

- Compatible with PHPUnit
- Can process scenarios

Usage
-----

### API Methods
```php

require_once 'vendor/autoload.php';

$unit = new HttpUnit\HttpUnit();

$unit->addScenario([ 'request' => ['path' => '/index.php'] ]);

$unit->assertResponseCode(200);

```
