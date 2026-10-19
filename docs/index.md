![doctrine-diagram-bundle](https://socialify.git.ci/jawira/doctrine-diagram-bundle/image?&description=1&font=Jost&forks=1&issues=1&language=1&owner=1&pattern=Solid&pulls=1&stargazers=1&theme=Auto)

**_DoctrineDiagramBundle_ is a Symfony bundle that generates ER and Class diagrams
representing the current state of your database.**

This bundle is not intended as a design tool but rather as a utility for
monitoring and visualizing database schema status.

## Features

* Generate Entity-Relationship and UML Class diagrams from your Doctrine
  schema.
* Choose the level of detail: _mini_, _midi_, or _maxi_.
* Export diagrams as _puml_, _svg_, or _png_.
* Style diagrams with built-in PlantUML themes.
* Filter the entities or tables that appear in a diagram.
* Convert PlantUML output locally (jar) or via a remote server.

## Getting started

1. [Install the bundle](installing.md)
2. [Generating diagrams](usage.md)
3. [Configure the bundle](configuration.md)

For conversion setup, see [PlantUML setup](plantuml.md). If generation fails,
check the [known issues](known-issues.md).

## Requirements

* PHP 8.2+
* Symfony 7.x or 8.x
* [PlantUML](plantuml.md) *(only needed for `png` / `svg` output)*
