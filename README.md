# Doctrine Diagram Bundle

**📐 Symfony Bundle to generate database diagrams.**

[![Latest Stable Version](http://poser.pugx.org/jawira/doctrine-diagram-bundle/v)](https://packagist.org/packages/jawira/doctrine-diagram-bundle)
[![Total Downloads](http://poser.pugx.org/jawira/doctrine-diagram-bundle/downloads)](https://packagist.org/packages/jawira/doctrine-diagram-bundle)
[![PHP Version Require](http://poser.pugx.org/jawira/doctrine-diagram-bundle/require/php)](https://packagist.org/packages/jawira/doctrine-diagram-bundle)
[![License](http://poser.pugx.org/jawira/doctrine-diagram-bundle/license)](https://packagist.org/packages/jawira/doctrine-diagram-bundle)

Features:

* Multiple size diagrams: `mini`, `midi`, and `maxi`.
* File formats: `svg`, `png`, and `puml`.
* Filtering: display only selected tables/classes.
* Theme customisation.

## Installation

```bash
composer config extra.symfony.allow-contrib true
composer require jawira/doctrine-diagram-bundle --dev
```

## Usage

```console
# Entity-relationship diagram
bin/console doctrine:diagram:er

# Class diagram
bin/console doctrine:diagram:class
```

Then open `er.svg` and `class.svg` located at the root of your project:

![Entity-relationship diagram](docs/images/er.svg)

![Class diagram](docs/images/class.svg)

## Documentation

<https://jawira.github.io/doctrine-diagram-bundle/>

## Contributing

* Please report any bug.
* If you liked this project, ⭐ star it on GitHub.
* Or follow me on 𝕏. [![𝕏 Follow](https://img.shields.io/twitter/follow/jawira?style=social)](https://x.com/jawira)

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
