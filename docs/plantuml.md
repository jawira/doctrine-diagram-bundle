PlantUML is required to save diagrams in `png` or `svg` format.
By default, _DoctrineDiagramBundle_ will use the public PlantUML web
server: <https://www.plantuml.com/plantuml/> to generate those images.

_DoctrineDiagramBundle_ can use either a locally installed version of PlantUML
or connect to a remote PlantUML server.

This bundle requires a relatively recent version of PlantUML; versions newer
than `v1.2022.0` are recommended. Check the
[Known issues](known-issues.md) page for version-specific compatibility notes.

## Installing PlantUML locally

### Requirements

To work properly, PlantUML has the following requirements:

* java 8
* GraphViz - [Installing GraphViz](https://plantuml.com/en/graphviz-dot)

Please follow the official documentation to learn how to install PlantUML in
your OS: <https://plantuml.com/en/starting>

### Installing PlantUML with Composer

I have developed a convenience package to install PlantUML using Composer.

<https://packagist.org/packages/jawira/plantuml>

```console
composer require jawira/plantuml
```

You will find `plantuml.jar` inside `vendor` directory:<br>
`./vendor/jawira/plantuml/bin/plantuml.jar`.

## PlantUML server

A PlantUML server is required if you want to save diagrams in `png` and `svg`
formats.

### PlantUML server with Docker

An alternative method to set up a PlantUML server involves leveraging Docker.

Use Docker to establish a PlantUML server using the following command. This
command ensures that the server is accessible via port 8080.

```console
docker run -d -p 8080:8080 plantuml/plantuml-server:jetty
```

The PlantUML server endpoint includes the `/plantuml` path. Set it in
`doctrine_diagram.yaml` as shown below.

```yaml
# config/packages/doctrine_diagram.yaml
doctrine_diagram:
    # ...
    convert:
        server: 'http://localhost:8080/plantuml'
```

For further details, refer
to: [PlantUML in Docker Hub](https://hub.docker.com/r/plantuml/plantuml-server)

### Running PlantUML picoserver

First, ensure you have PlantUML installed on your system.
Then run following command to create a local PlantUML server available on port
8080:

```console
plantuml -picoserver:8080
```

Once executed, your server becomes accessible through <http://localhost:8080>.
Additionally, declare this new server in `config/packages/doctrine_diagram.yaml`
as follows:

```yaml
# config/packages/doctrine_diagram.yaml
doctrine_diagram:
    # ...
    convert:
        server: 'http://localhost:8080/plantuml'
```

For more information
visit: [PlantUML Picoweb Documentation](https://plantuml.com/picoweb)
