## Install _DoctrineDiagramBundle_ with Symfony Flex

Open a command console, enter your project directory and enable recipes:

```console
composer config extra.symfony.allow-contrib true
```

Then install _DoctrineDiagramBundle_:

```console
composer require jawira/doctrine-diagram-bundle --dev
```

## Applications that don't use Symfony Flex

Follow these steps to install DoctrineDiagramBundle in project that don't use
Symfony Flex.

**Step 1: Download the Bundle**

Open a command console, enter your project directory and execute the following
command to download the latest stable version of this bundle:

```console
composer require jawira/doctrine-diagram-bundle --dev
```

**Step 2: Enable the Bundle**

Then, enable the bundle by adding it to the list of registered bundles in
the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    \Jawira\DoctrineDiagramBundle\DoctrineDiagramBundle::class => ['dev' => true, 'test' => true ],
];
```
