_DoctrineDiagramBundle_ provides two _Symfony_ commands to generate diagrams
from your database:

* `doctrine:diagram:er` - To generate Entity-Relationship diagrams.
* `doctrine:diagram:class` - To generate Class diagrams.

## Generating Entity-Relationship diagrams

An Entity-Relationship (ER) diagram visually represents the entities (such as
tables) in a database, their attributes (such as columns), and the relationships
between them.

Use the following command to generate Entity-Relationship diagrams:

```console
bin/console doctrine:diagram:er
```

You can also use the following shortcut:

```console
bin/console d:d:er
```

If you are using the default configuration, a file named `er.svg` will be
created at the root of your project.

![er diagram](images/er.svg)

If your application uses multiple databases, you can specify which DBAL
connection to use using the `--connection` option:

```console
bin/console doctrine:diagram:er --connection=employees
```

You can also set the DBAL connection in `doctrine_diagram.yaml`.
See [configuration](configuration.md) for the available command options and
configuration file settings.

```yaml
doctrine_diagram:
    er:
        connection: employees
```

Set `connection` to `null`, and the default connection will be used.

## Generating Class diagrams

A UML Class diagram visually represents the Doctrine Entities in your project,
including their properties, methods, and the relationships between them.

Use the following command to generate Class diagrams:

```console
bin/console doctrine:diagram:class
```

You can also use the following shortcut:

```console
bin/console d:d:class
```

!!! info

    _DoctrineDiagramBundle_ will only use _Doctrine entities_ to generate the
    diagram. Additionally, only properties with the `ORM\Column` attribute are
    displayed, other class properties are ignored.

If you are using the default configuration, a file named `class.svg` will be
created at the root of your project.

![Class diagram](images/class.svg)

If your application uses multiple databases, you can specify which Entity
Manager to use using the `--em` option:

```console
bin/console doctrine:diagram:class --em=customers
```

In `doctrine_diagram.yaml`:

```yaml
doctrine_diagram:
    class:
        em: customers
```

Set `em` to `null`, and the default Entity Manager will be used.

## How to pipe output

Use `php://stdout` as the destination file to redirect image to standard output.

For example:

```console
bin/console doctrine:diagram:er --filename="php://stdout" --format=puml | tee diagram.puml
```
