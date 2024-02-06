### Error: "Failed to open stream: HTTP request failed!"

This error occurs when you are trying to generate a diagram in SVG or PNG
formats, and you are using the public PlantUML server.

The problem is that the diagram you are trying to create is too large, and the
PlantUML server has limited diagram sizes to avoid abuse.

**Solution 1**

Generate a diagram in PUML format. This diagram is generated locally and doesn't
require the PlantUML server. Then, use the `plantuml` executable locally to
convert the PUML diagram to the desired format.

```console
bin/console doctrine:diagram --format=puml
```

**Solution 2**

Do not use the public PlantUML server; use your own PlantUML server instead. To
create your own server, you can use Docker.

Then, access your server using the command option `--server`, or in the
`doctrine_diagram.yaml` file.

### Error 'Unknown column type "uuid" requested'

You encounter the following error when trying to generate a diagram:

> CRITICAL  [console] Error thrown while running command "doctrine:diagram".
> Message: "Unknown column type "uuid" requested. Any Doctrine type that you use
> has to be registered with \Doctrine\DBAL\Types\Type::addType().

To fix this error, add a custom type in the doctrine.yaml config file.

```yaml

doctrine:
  dbal:
    # ...
    types:
      uuid: Symfony\Bridge\Doctrine\Types\UuidType
```

