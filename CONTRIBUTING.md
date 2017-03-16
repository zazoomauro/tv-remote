# Issues
Issues are always very welcome. 
However, there are a couple of things you can do to make the lives of the developers much easier:

### Tell us:

* What you are doing?
  * Post a _minimal_ code sample that reproduces the issue
  * What do you expect to happen?
  * What is actually happening?
* Which NodeJS version you are using?
* Which Ecma Script version you are using?
* Which Ecma Script presets you are using?

When you post code, please use [Github flavored markdown](https://help.github.com/articles/github-flavored-markdown), 
in order to get proper syntax highlighting!

# Pull requests

We're glad to get pull request if any functionality is missing or something is buggy. 
However, there are a couple of things you can do to make life easier for the maintainers:

* Explain the issue that your PR is solving - or link to an existing issue
* Make sure that all existing tests pass
* Make sure you followed [PSR1/PSR2](http://www.php-fig.org/psr/)
* Add some tests for your new functionality or a test exhibiting the bug you are solving. Ideally all new tests should not pass _without_ your changes.
* If you are adding or changing the public API, remember to add this changes in to the README file.
* Add an entry to the [changelog](CHANGELOG.md), following the [changelog rules](http://keepachangelog.com/)

### 1. Prepare your environment

You need [PHP](http://php.net) and [composer](https://getcomposer.org)

### 2. Install dependencies

Run `composer install`, see an example below:

```console
$ composer install
```

### 3. Run tests ###

All tests are located in the `test` folder (which contains the [Mocha](http://visionmedia.github.io/mocha/) tests).

```console
$ composer test
```

### 4. Standard Coding Guidelines ###

Please, follow [PSR1](http://www.php-fig.org/psr/psr-1/) and [PSR2](http://www.php-fig.org/psr/psr-2/)

And then make and commit your changes

### 5. Done ###

Just commit and send your pull request. 
Thank you for contributing.
