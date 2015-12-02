## finder

[![Build Status](https://secure.travis-ci.org/ehough/finder.png)](http://travis-ci.org/ehough/finder)
[![Project Status: Inactive - The project has reached a stable, usable state but is no longer being actively developed; support/maintenance will be provided as time allows.](http://www.repostatus.org/badges/latest/inactive.svg)](http://www.repostatus.org/#inactive)
[![Latest Stable Version](https://poser.pugx.org/ehough/finder/v/stable)](https://packagist.org/packages/ehough/finder)
[![License](https://poser.pugx.org/ehough/finder/license)](https://packagist.org/packages/ehough/finder)

Fork of [Symfony's Finder component](https://github.com/symfony/Finder) compatible with PHP 5.2+.

### Motivation

[Symfony's Finder component](https://github.com/symfony/Finder) is a fantastic library,
but it's only compatible with PHP 5.3+. While 99% of PHP servers run PHP 5.2 or higher,
13% of all servers are still running PHP 5.2 or lower ([source](http://w3techs.com/technologies/details/pl-php/5/all)).

**Version 2.8.0 will likely be the last release of this library** since PHP 5.2 levels are finally falling below 10%.

### Differences from [Symfony's Finder component](https://github.com/symfony/Finder)

The primary difference is naming conventions of the Symfony classes.
Instead of the `\Symfony\Component\Finder` namespace (and sub-namespaces), prefix the Symfony class names
with `ehough_finder` and follow the [PEAR naming convention](http://pear.php.net/manual/en/standards.php)

A few examples of class naming conversions:

    \Symfony\Component\Finder\Finder                  ----->    ehough_finder_Finder
    \Symfony\Component\Finder\Expression\Expression   ----->    ehough_finder_expression_Expression
    \Symfony\Component\Finder\Shell\Command           ----->    ehough_finder_shell_Command

### Usage

Finder finds files and directories via an intuitive fluent interface.

```php
$finder = new ehough_finder_Finder();

$iterator = $finder
  ->files()
  ->name('*.php')
  ->depth(0)
  ->size('>= 1K')
  ->in(__DIR__);

foreach ($iterator as $file) {
    print $file->getRealpath()."\n";
}
```

But you can also use it to find files stored remotely like in this example where
we are looking for files on Amazon S3:

```php
$s3 = new Zend_Service_Amazon_S3($key, $secret);
$s3->registerStreamWrapper("s3");

$finder = new ehough_finder_Finder();
$finder->name('photos*')->size('< 100K')->date('since 1 hour ago');
foreach ($finder->in('s3://bucket-name') as $file) {
    print $file->getFilename()."\n";
}
```

### Releases and Versioning

Releases are synchronized with the upstream Symfony repository. e.g. `ehough/finder v2.3.1` has merged the code
from `Symfony/Finder v2.3.1`.
