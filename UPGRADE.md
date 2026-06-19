# Upgrade from 1.x to 2.0

This document describes the changes required to migrate from `v1` to `v2`.

## Breaking changes

### The `--exclude` option

Previously, the `--exclude` option was a comma separated list of values.

```console
--exclude=user,customer,invoice
```

In v2 you have to split this value into multiple `--exclude` calls:

```console
--exclude=user --exclude=customer --exclude=invoice
```

This change applies to `doctrine:diagram:er` and `doctrine:diagram:class` command.
