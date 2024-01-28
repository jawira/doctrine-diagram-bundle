## How to pipe output

Use `php://stdout` as destination file to redirect image to standard output.

For example:

```console
bin/console doctrine:diagram --filename="php://stdout" --format=puml | tee diagram.puml
```
