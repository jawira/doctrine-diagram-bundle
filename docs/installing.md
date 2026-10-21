## Requirements

_DoctrineDiagramBundle_ requires PHP 8.2 or later, Symfony 7 or 8, Doctrine
Bundle 2.5 or later in the 2.x series or 3.x, and Doctrine ORM 2.9 or later in
the 2.x series or 3.x. Composer installs the required dependencies with the
bundle.

PlantUML is needed only when you want diagrams in `svg` or `png` format. You can
install it locally or use a PlantUML server; see [PlantUML setup](plantuml.md).
The `puml` format does not require PlantUML.

## Install with Symfony Flex

In your project directory, allow community-contributed Symfony recipes if you
have not already enabled them:

```console
composer config extra.symfony.allow-contrib true
```

Then install the bundle as a development dependency:

```console
composer require jawira/doctrine-diagram-bundle --dev
```

Symfony Flex installs the bundle recipe, which registers the bundle for the
`dev` and `test` environments. Review the recipe changes in your project.

## Install without Symfony Flex

Install the bundle with Composer:

```console
composer require jawira/doctrine-diagram-bundle --dev
```

Register the bundle in `config/bundles.php`:

```php
<?php

return [
    // ...
    Jawira\DoctrineDiagramBundle\DoctrineDiagramBundle::class => ['dev' => true, 'test' => true],
];
```
