# BCA Inspector Tools for Laravel

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

#### Editing composer.json manually

First, add `"bca/laravel-inspect": "dev-master"` to the `require` section.

```json
"require": {
    "laravel/framework": "4.0.*",
    "bca/laravel-inspect": "dev-master"
}
```

Next, update Composer from the Terminal:

```sh
composer update
```

#### Installation via the command line

```sh
composer require bca/laravel-inspect:dev-master
```

### 2. Add the service provider
Once the package has been successfully installed, the final step is to add the service provider. Open `app/config/app.php`, and add a new item to the providers array:

```
'BCA\LaravelInspect\LaravelInspectServiceProvider'
```

### 3. Enjoy!

That's all, folks! Just type `php artisan` from the root directory of your Laravel installation to see your new tools!

## Advanced Usage

We've crafted rules for the tools that we've provided that match the coding style of the Laravel project itself.  That said, one size doesn't fit all, and there is no reason why you can't use the [PEAR style guide](http://pear.php.net/manual/en/standards.php), [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md), or invent one of your own!

### Custom Rulesets

Both PHP Code Sniffer and PHP Mess Detector support the creation of custom rulesets.

#### PHP Code Sniffer

To create a custom ruleset for use with the `inspect:sniff` command just drop a ruleset named `phpcs.xml` in the root of your Laravel installation.  You may then use this [annotated ruleset](http://pear.php.net/manual/en/package.php.php-codesniffer.annotated-ruleset.php) as a guide in creating your own.

You may also run `php artisan inspect:sniff --install-ruleset` to copy our rules to your project so that you can modify them.

#### PHP Mess Detector

To create a custom ruleset for use with the `inspect:mess` command just drop a ruleset named `phpmd.xml` in the root of your Laravel installation.  The PHPMD website offers instructions on how to [create a ruleset](http://phpmd.org/documentation/creating-a-ruleset.html).

You may also run `php artisan inspect:mess --install-ruleset` to copy our rules to your project so that you can modify them.
