## Create an ER diagram

To generate an ER diagram from your current Doctrine database, use the following
command:

```console
bin/console doctrine:diagram
```

If you are using the default configuration, a file named `database.png` will be
created at the root of your project.

## Change the diagram format

Three formats are supported: `png`, `svg`, and `puml`.

You can set the format from the terminal using the --format option:

```console
bin/console doctrine:diagram --format=puml
```

Alternatively, you can set the format in config/packages/doctrine_diagram.yaml:

```yaml
doctrine_diagram:
    # ...
    format: png
```

If you encounter difficulties generating your diagram, use the puml format as it
doesn't require a PlantUML server to function.

## Set diagram size

You can generate diagrams in different sizes:

* **mini**: Display only table names.
* **midi**: Include tables and columns.
* **maxi**: Show table names, columns, and views.

Adjust the diagram size using the `--size` option:

```console
bin/console doctrine:diagram --size=mini
```

Alternatively, set the diagram size in the config file:

```yaml
doctrine_diagram:
    # ...
    size: mini
```

## Specify ER diagram name

By default, the diagram filename is `database`, and the file extension is added
automatically based on the chosen format. Modify the filename on-the-fly with
the `--filename` option:

```console
bin/console doctrine:diagram --filename=my-database
```

Alternatively, specify the filename in `config/packages/doctrine_diagram.yaml`:

```yaml
doctrine_diagram:
    # ...
    filename: my-database
```

!!! TIP

    You don't need to explicitly set filename extension, it's autmatically added according to selected diagram format.

## Output redirection

To redirect the diagram output to a file or another program, set `php://output`
as the filename. For example:

```console 
bin/console doctrine:diagram --filename="php://stdout" --format=puml | tee example.puml
```

## Customize color and style

Change the style of your diagrams using themes.

Specify a theme using the `--theme` option:

```console
bin/console doctrine:diagram --theme=amiga
```

Alternatively, set the theme in the `doctrine_diagram.yaml` configuration file:

```yaml
doctrine_diagram:
    # ...
    theme: amiga
```

## Excluding tables

To exclude specific tables from the ER diagram, use the `--exclude`
option:

```console
bin/console doctrine:diagram --exclude=table1,table2,table3
```

In the config file, use the `exclude` key to declare tables you want to omit:

```yaml
doctrine_diagram:
    # ...
    exclude:
        - table1
        - table2
        - table3
```

## Specify the Doctrine connection

If a connection is not specified, the `default` connection is used. Use
the `--connection` option to declare an alternative connection:

```console
bin/console doctrine:diagram --connection=default
```

Set the default connection in the config file:

```yaml
doctrine_diagram:
    # ...
    connection: alternative
```

Set the connection to _null_, and the default connection will be used:

```yaml
doctrine_diagram:
    # ...
    connection: ~
```
