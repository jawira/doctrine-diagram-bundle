<?php declare(strict_types=1);

namespace Jawira\DoctrineDiagramBundle\Service;

/**
 * Save the diagram into a file.
 */
class DumpService
{
  public function __construct(
    private readonly Toolbox $toolbox,
    private readonly string  $erFilename,
    private readonly string  $classFilename,
    private readonly string  $format,
  ) {
  }

  /**
   * @param string      $content  The content to write into the file.
   * @param string|null $filename Target file name. This can be a path, {@see Filesystem} is able to handle it.
   * @param string|null $format   Target file extension.
   *
   * @return string The filename with the current extension.
   */
  public function dumpErDiagram(string $content, ?string $filename, ?string $format): string
  {
    // Fallback values from doctrine_diagram.yaml
    $filename ??= $this->erFilename;
    return $this->dumpDiagram($content, $filename, $format);
  }

  public function dumpClassDiagram(string $content, ?string $filename, ?string $format): string
  {
    // Fallback values from doctrine_diagram.yaml
    $filename ??= $this->classFilename;
    return $this->dumpDiagram($content, $filename, $format);
  }

  /**
   * Dump the image into a file.
   *
   * @param string      $content  The content to write into the file.
   * @param string      $filename Target file name. This can be a path, {@see Filesystem} is able to handle it.
   * @param string|null $format   Target file extension.
   */
  private function dumpDiagram(string $content, string $filename, ?string $format): string
  {
    // Fallback values from doctrine_diagram.yaml
    $format ??= $this->format;

    if (!$this->toolbox->isWrapper($filename)) {
      $filename = $this->toolbox->appendExtension($filename, $format);
    }
    file_put_contents($filename, $content);

    return $filename;
  }
}
