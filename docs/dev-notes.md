# Dev notes

## Dev project

Add this to `composer.json` in your **project** to use the local copy of **Diagram Bundle**.

```json
{
  "repositories": [{"type": "path", "url": "../doctrine-diagram-bundle"}]
}
```

Change `minimum-stability`:

```json
{
  "minimum-stability": "dev"
}
```

Set branch name:

```json
{
  "jawira/doctrine-diagram-bundle": "dev-theme"
}
```

## Documentation

In order to build documentation material theme is required

```console
pip install mkdocs-material
phing mkdocs:serve
```

## Check config

```console
bin/console debug:config doctrine_diagram
bin/console config:dump-reference doctrine_diagram
```
