HttpUnit
================

[![Build Status](https://travis-ci.org/landrok/language-detector.svg?branch=master)](https://travis-ci.org/landrok/language-detector)
[![Test Coverage](https://codeclimate.com/github/landrok/language-detector/badges/coverage.svg)](https://codeclimate.com/github/landrok/language-detector/coverage)
[![Code Climate](https://codeclimate.com/github/landrok/language-detector/badges/gpa.svg)](https://codeclimate.com/github/landrok/language-detector)

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
