# Doctrine Diagram Bundle

**📐 Symfony Bundle to generate database diagrams.**

> [!IMPORTANT]
> This project is still a *work in progress*, so you should expect BC breaks in
> future releases.<br>Please report any bug.

[![Latest Stable Version](http://poser.pugx.org/jawira/doctrine-diagram-bundle/v)](https://packagist.org/packages/jawira/doctrine-diagram-bundle)
[![Total Downloads](http://poser.pugx.org/jawira/doctrine-diagram-bundle/downloads)](https://packagist.org/packages/jawira/doctrine-diagram-bundle)
[![PHP Version Require](http://poser.pugx.org/jawira/doctrine-diagram-bundle/require/php)](https://packagist.org/packages/jawira/doctrine-diagram-bundle)
[![License](http://poser.pugx.org/jawira/doctrine-diagram-bundle/license)](https://packagist.org/packages/jawira/doctrine-diagram-bundle)

## Usage

Run this command to generate a database diagram:

```console
bin/console doctrine:diagram
```

Then open `database.svg` located at the root of your project:

![diagram](docs/midi.png)

## How to install with Symfony Flex

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Open a command console, enter your project directory and install with Composer:

```console
composer require jawira/doctrine-diagram-bundle
```

<details>
<summary>Applications that don't use Symfony Flex</summary>

#### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
composer require jawira/doctrine-diagram-bundle
```

#### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    \Jawira\DoctrineDiagramBundle\DoctrineDiagramBundle::class => ['all' => true],
];
```

#### Step 3 (optional): Create config file

Create a new configuration file in `config/packages/doctrine_diagram.yaml` and
paste the following content:

```yaml
# config/packages/doctrine_diagram.yaml
doctrine_diagram:
    size: midi
    filename: database
    format: svg
```

</details>

## Contributing

If you liked this project,
⭐ [star it on GitHub](https://github.com/jawira/doctrine-diagram-bundle).

## License

This library is licensed under the [MIT license](LICENSE.md).

***

## Packages from jawira

<dl>

<dt>
  <a href="https://packagist.org/packages/jawira/plantuml">jawira/plantuml
  <img alt="GitHub stars" src="https://badgen.net/github/stars/jawira/plantuml?icon=github"/></a>
</dt>
<dd>Provides PlantUML executable and plantuml.jar</dd>

<dt><a href="https://packagist.org/packages/jawira/">more...</a></dt>
</dl>
