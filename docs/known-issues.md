## Incompatible versions

PlantUML implemented some changes in _class diagrams_, as a consequence
_DoctrineDiagramBundle_ displays the following error:

```text
Failed to open stream: HTTP request failed! HTTP/1.1 400 Bad Request
```

The following versions are incompatible with _DoctrineDiagramBundle_.

* _PlantUML v1.2026.7_
* _PlantUML v1.2026.8_

The issue is reported for _PlantUML v1.2026.7_ and _v1.2026.8_. Check the
issue links below for updates and use a different PlantUML version if affected.

By default, the bundle uses the public PlantUML server, whose version can
change independently of your application. Configure a local installation or a
custom server to control the PlantUML version.

A workaround to this problem is to use a different version of PlantUML server,
learn how to do this in [PlantUML setup](plantuml.md). Then follow
instructions in [Configure the bundle](configuration.md) to specify which
PlantUML version to use.

You can find more details about the issue in:

* <https://github.com/jawira/doctrine-diagram-bundle/issues/87>
* <https://github.com/jawira/doctrine-diagram-bundle/issues/88>

## Error: "Failed to open stream: HTTP request failed!"

This error occurs when you are trying to generate a diagram in SVG or PNG
formats, and you are using the public PlantUML server.

The problem is that the diagram you are trying to create is too large, and the
PlantUML server has limited diagram sizes to avoid abuse.

**Solution 1**

Use PlantUML locally instead of a web server. This is explained
in [Configuration](configuration.md) page.

**Solution 2**

Generate a diagram in PUML format. This diagram is generated locally and doesn't
require the PlantUML server. Then, use the `plantuml` executable locally to
convert the PUML diagram to the desired format.

```console
bin/console doctrine:diagram:er --format=puml
bin/console doctrine:diagram:class --format=puml
```

**Solution 3**

Do not use the public PlantUML
server; [use your own PlantUML server instead](./plantuml.md).

Then, access your server using the command option `--server`, or in the
`doctrine_diagram.yaml` file.

## Error 'Unknown column type "uuid" requested'

You encounter the following error when trying to generate a diagram:

> CRITICAL  [console] Error thrown while running command "doctrine:diagram".
> Message: "Unknown column type "uuid" requested. Any Doctrine type that you use
> has to be registered with \Doctrine\DBAL\Types\Type::addType ().

To fix this error, add a custom type in the doctrine.yaml config file.
For example:

```yaml

doctrine:
    dbal:
        types:
            uuid: Symfony\Bridge\Doctrine\Types\UuidType
```

Source: [Registering custom Mapping Types](https://symfony.com/doc/current/doctrine/dbal.html#registering-custom-mapping-types).

## Error "Syntax Error"

When trying to generate a diagram, you get the following error in the terminal:

```console
Error Output:
================
ERROR
7
Syntax Error?
Some diagram description contains errors
```

**Solution**

Use a newer version of PlantUML, older versions of PlantUML do not support
features like _themes_ and custom _namespace separators_.
