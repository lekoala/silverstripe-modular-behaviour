# SilverStripe Modular Behaviour module

[![Build Status](https://travis-ci.com/lekoala/silverstripe-modular-behaviour.svg?branch=master)](https://travis-ci.com/lekoala/silverstripe-modular-behaviour/)
[![scrutinizer](https://scrutinizer-ci.com/g/lekoala/silverstripe-modular-behaviour/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/lekoala/silverstripe-modular-behaviour/)
[![Code coverage](https://codecov.io/gh/lekoala/silverstripe-modular-behaviour/branch/master/graph/badge.svg)](https://codecov.io/gh/lekoala/silverstripe-modular-behaviour)

## Intro

Allow usage of [modular-behaviour](https://github.com/lekoala/modular-behaviour.js) in Silverstripe.

ModularBehaviour is a tool that helps you to bind behaviour to a specific html node. As such, it works in a similar fashion than entwine, but works
consistently in frontend and backend in a standalone fashion, because forcing usage of entwine in the frontend is not always feasible.

## How to use

Simply extend `ModularFormField` instead of `FormField`. If it's not possible, simply use the `ModularBehaviour` trait.
This module is mainly built with FormFields in mind, but it should work just fine for widgets, etc.

You can then override as needed any of the built in methods:
- getModularManual
- getModularSrc
- getModularSelector
- getModularFunc
- getModularName
- getModularConfig
- getModularConfigName

Please refer to the phpdoc for detailed usage.

Here is an example:

```php
class MyModularField extends ModularFormField {
    public function getModularName()
    {
        return 'MyApp.MyModularField';
    }

    public function getModularSelector()
    {
        return '.my-modular-field';
    }

    public function getModularConfigName()
    {
        return str_replace('-', '_', $this->ID()) . '_config';
    }

    public function getModularConfig()
    {
        $script = $this->getInitScript();
        $configName = $this->getModularConfigName();
        $script = "var $configName = $script";
        return $script;
    }
}
```

## Lazy

Fields wrapped by modular behaviour can lazily load themselves (which is very useful when used in long pages
or in tabs).

Simply call `setModularLazy` and pass `true` and it should all work magically.

## Dynamic src

You can also (lazily if needed) load the source script instead of relying on the requirements api.

Simply override `getModularSrc` to return the public path to the js file that contains the constructor.

## ESM Note

Due to ajax scripts being loaded through globalEval and not supporting esm module (export not recognized), the min
file is built using iife.

## Compatibility

Tested with ^4.10 but should work on any 4.x projects

## Maintainer

LeKoala - thomas@lekoala.be
