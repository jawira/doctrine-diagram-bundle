## How to configure the bundle

You have to ways to configure _Doctrine Diagram Bundle_.

1. Using configuration file
2. Using command's options

### Configuration file

Configuation file is located at `config/packages/doctrine_diagram.yaml`:

```yaml
doctrine_diagram:
    size: midi
    filename: database
    format: svg
    server: 'http://www.plantuml.com/plantuml'
    theme: _none_
    connection: null
```

### Command's options

Use `help` command to see available options.

```console
bin/console help doctrine:diagram
```

Command's options are:

```console
Options:
  --filename=FILENAME      Destination file name.
  --format=FORMAT          Diagram format (svg, png or puml).
  --size=SIZE              Diagram size (mini, midi or maxi).
  --server=SERVER          PlantUML server URL, only used to convert puml diagrams to svg and png.
  --connection=CONNECTION  Doctrine connection to use.
  --theme=THEME            Change diagram colors and style.
```
