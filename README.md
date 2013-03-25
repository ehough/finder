# finder [![Build Status](https://secure.travis-ci.org/ehough/finder.png)](http://travis-ci.org/ehough/finder)

Fork of [Symfony's Finder component](https://github.com/symfony/Finder) compatible with PHP 5.2+.

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

But you can also use it to find files stored remotely like in this example where
we are looking for files on Amazon S3:

$s3 = new \Zend_Service_Amazon_S3($key, $secret);
$s3->registerStreamWrapper("s3");

$finder = new ehough_finder_Finder();
$finder->name('photos*')->size('< 100K')->date('since 1 hour ago');
foreach ($finder->in('s3://bucket-name') as $file) {
    print $file->getFilename()."\n";
}
```
