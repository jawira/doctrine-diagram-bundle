## Install DoctrineDiagramBundle with Symfony Flex

Make sure Composer is installed globally, as explained in
the [installation chapter](https://getcomposer.org/doc/00-intro.md) of the
Composer documentation.

Open a command console, enter your project directory and allow project's
recipes:

```console
composer config extra.symfony.allow-contrib true
```

Then install _Doctrine Diagram Bundle_:

```console
composer require jawira/doctrine-diagram-bundle
```

## Applications that don't use Symfony Flex

Follow these steps to install DoctrineDiagramBundle in project that don't use
Symfony Flex.

**Step 1: Download the Bundle**

Open a command console, enter your project directory and execute the following
command to download the latest stable version of this bundle:

```console
composer require jawira/doctrine-diagram-bundle
```

**Step 2: Enable the Bundle**

Then, enable the bundle by adding it to the list of registered bundles in
the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    \Jawira\DoctrineDiagramBundle\DoctrineDiagramBundle::class => ['all' => true],
];
```

**Step 3 (optional): Create config file**

Create a new configuration file in `config/packages/doctrine_diagram.yaml` and
paste the following content:

```yaml
# config/packages/doctrine_diagram.yaml
doctrine_diagram:
    size: midi
    filename: database.svg
    format: svg
```

## Installing you own PlantUML server

A PlantUML server is required if you want to save diagrams in `png` and `svg`
formats.

### Running PlantUML picoserver

First, ensure you have PlantUML installed on your system.
Then run following command to create a local PlantUML server available on port
8080:

```console
plantuml -picoserver:8080
```

Once executed, your server becomes accessible through <http://localhost:8080>.
Additionally, declare this new server in config/packages/doctrine_diagram.yaml
as follows:

```yaml
doctrine_diagram:
  # ...
  server: http://localhost:8080/plantuml
```

For more information
visit: [PlantUML Picoweb Documentation](https://plantuml.com/picoweb)

### PlantUML server with Docker

An alternative method to set up a PlantUML server involves leveraging Docker.

Utilize Docker to establish a PlantUML server using the following command. This
command ensures that the server is accessible via port 8080.

```console
docker run -d -p 8080:8080 plantuml/plantuml-server:jetty
```

Notice that, when using Docker, `/plantuml` path is not used
in `doctrine_diagram.yaml`.

```yaml
doctrine_diagram:
  # ...
  server: http://localhost:8080
```

For further details, refer
to: [PlantUML in Docker Hub](https://hub.docker.com/r/plantuml/plantuml-server)
