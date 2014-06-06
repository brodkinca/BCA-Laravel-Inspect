# BCA Inspector Tools for Laravel

[![Build Status](https://secure.travis-ci.org/brodkinca/BCA-Laravel-Inspect.png)](http://travis-ci.org/brodkinca/BCA-Laravel-Inspect)
[![Dependencies Status](https://depending.in/brodkinca/BCA-Laravel-Inspect.png)](http://depending.in/brodkinca/BCA-Laravel-Inspect)
[![Coverage Status](https://coveralls.io/repos/brodkinca/BCA-Laravel-Inspect/badge.png)](https://coveralls.io/r/brodkinca/BCA-Laravel-Inspect)

[![Latest Stable Version](https://poser.pugx.org/bca/laravel-inspect/v/stable.png)](https://packagist.org/packages/bca/laravel-inspect) 
[![Total Downloads](https://poser.pugx.org/bca/laravel-inspect/downloads.png)](https://packagist.org/packages/bca/laravel-inspect) 
[![License](https://poser.pugx.org/bca/laravel-inspect/license.png)](https://packagist.org/packages/bca/laravel-inspect)

Inspect your code via the Artisan CLI using industry-standard tools.

This Laravel 4 package adds several pre-configured tools to the Artisan CLI, speeding up your development process and making your code cleaner.

The tools currently provided are:
- [PHP Code Sniffer](http://www.squizlabs.com/php-codesniffer)
- [PHP CS Fixer](http://cs.sensiolabs.org/)
- [PHP Mess Detector](http://phpmd.org/)
- PHP's Native Linter

## Installation

### 1. Add the package to Composer
This package should be installed via Composer. You may either edit your project's `composer.json` file to require `bca/laravel-inspect` or via the command line.

```sh
composer require bca/laravel-inspect:~1.3
```

### 2. Add the service provider
Once the package has been successfully installed, the final step is to add the service provider. Open `app/config/app.php`, and add a new item to the providers array:

```
'BCA\LaravelInspect\LaravelInspectServiceProvider'
```

### 3. Enjoy!

That's all, folks! Just type `./artisan` from the root directory of your Laravel installation to see your new tools!

## Advanced Usage

We've crafted rules for the tools that we've provided that match the coding style of the Laravel project itself.  That said, one size doesn't fit all, and there is no reason why you can't use the [PEAR style guide](http://pear.php.net/manual/en/standards.php), [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md), or invent one of your own!

### Custom Rulesets

Both PHP Code Sniffer and PHP Mess Detector support the creation of custom rulesets.

#### PHP Code Sniffer

To create a custom ruleset for use with the `inspect:sniff` command just drop a ruleset named `phpcs.xml` in Laravel's `app` directory.  You may then use this [annotated ruleset](http://pear.php.net/manual/en/package.php.php-codesniffer.annotated-ruleset.php) as a guide in creating your own.

You may also run `php artisan inspect:sniff --install-ruleset` to copy our rules to your project so that you can modify them.

#### PHP Mess Detector

To create a custom ruleset for use with the `inspect:mess` command just drop a ruleset named `phpmd.xml` in Laravel's `app` directory.  The PHPMD website offers instructions on how to [create a ruleset](http://phpmd.org/documentation/creating-a-ruleset.html).

You may also run `php artisan inspect:mess --install-ruleset` to copy our rules to your project so that you can modify them.


## Contributing

This project will be maintained on Github at https://github.com/brodkinca/BCA-Laravel-Inspect.  You will also find this project's [Issue Tracker](https://github.com/brodkinca/BCA-Laravel-Inspect/issues) there.

### Versioning

This library will be maintained under the Semantic Versioning guidelines.

Releases will be numbered with the following format:

```
<major>.<minor>.<patch>
```

And constructed with the following guidelines:

* Breaking backward compatibility bumps the major (and resets the minor and patch)
* New additions without breaking backward compatibility bumps the minor (and resets the patch)
* Bug fixes and misc changes bump the patch

For more information on SemVer, please visit http://semver.org/.

### Testing

Due to the peculiarities of the Artisan CLI it is not possible to run the unit tests outside of the context of a full Laravel application. Instead, this package should be installed within a copy of Laravel, as a workbench application, and then added to that installation's phpunit.xml file. For this reason it is recommended that you run a development copy of Laravel for package development.

Please run all unit tests before submitting any code!

**NOTE:** Running the unit tests will erase any phpcs/phpmd configuration files in your `app` directory without warning!!!
