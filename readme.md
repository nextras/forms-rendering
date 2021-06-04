Nextras Forms Rendering
=======================

[![Build Status](https://travis-ci.org/nextras/forms-rendering.svg?branch=master)](https://travis-ci.org/nextras/forms-rendering)
[![Downloads this Month](https://img.shields.io/packagist/dm/nextras/forms-rendering.svg?style=flat)](https://packagist.org/packages/nextras/forms-rendering)
[![Stable version](http://img.shields.io/packagist/v/nextras/forms-rendering.svg?style=flat)](https://packagist.org/packages/nextras/forms-rendering)

This package provides rendering helpers Nette Forms.

Form renderers:
- *Bs3Renderer* - renderer for Bootstrap 3 with horizontal mode only;
- *Bs4Renderer* - renderer for Bootstrap 4 with support for horizontal, vertial and inline mode;
- *Bs5Renderer* - renderer for Bootstrap 5 with support for horizontal, vertial and inline mode;

Latte Macros renderers:
- *Bs3InputMacros* - modifies Form Macros to add Bootstrap 3 classes automatically;

### Installation

The best way to install is using [Composer](http://getcomposer.org/):

```sh
$ composer require nextras/forms-rendering
```

Register Bs3InputMacros using Nette DI config:

```yaml
latte:
    macros:
        - Nextras\FormsRendering\LatteMacros\Bs3InputMacros::install
```

### Documentation

See examples directory.


### License

MIT. See full [license](license.md).
