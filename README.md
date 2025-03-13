# Doctrine Diagram Bundle

**📐 Symfony Bundle to generate database diagrams.**

> [!IMPORTANT]
> This project is still a *work in progress*, so you should expect BC breaks in
> future releases.<br>Please report any bug.

[![Latest Stable Version](http://poser.pugx.org/jawira/doctrine-diagram-bundle/v)](https://packagist.org/packages/jawira/doctrine-diagram-bundle)
[![Total Downloads](http://poser.pugx.org/jawira/doctrine-diagram-bundle/downloads)](https://packagist.org/packages/jawira/doctrine-diagram-bundle)
[![PHP Version Require](http://poser.pugx.org/jawira/doctrine-diagram-bundle/require/php)](https://packagist.org/packages/jawira/doctrine-diagram-bundle)
[![License](http://poser.pugx.org/jawira/doctrine-diagram-bundle/license)](https://packagist.org/packages/jawira/doctrine-diagram-bundle)

## Installation

```bash
composer config extra.symfony.allow-contrib true
composer require jawira/doctrine-diagram-bundle --dev
```

## Usage

Run this command to generate a _ER_ diagram:

```console
bin/console doctrine:diagram
```

Then open `database.svg` located at the root of your project:

![diagram](docs/images/midi.png)

## Documentation

<https://jawira.github.io/doctrine-diagram-bundle/>

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
