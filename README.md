CommandRunnerBundle
===================

Executes Symfony2 console command from a Controller.

Installation
------------

This bundle is available on [Packagist](https://packagist.org/packages/mrafalko/command-runner-bundle):

To install it, run:

    $ composer require mrafalko/command-runner-bundle:dev-master

Then add the bundle to `app/AppKernel.php`:

```
public function registerBundles()
{
    return array(
        ...
        new Mrafalko\CommandRunnerBundle\MrafalkoCommandRunnerBundle(),
        ...
    );
}
```