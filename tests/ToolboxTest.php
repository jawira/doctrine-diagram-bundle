<?php declare(strict_types=1);

use Jawira\DoctrineDiagramBundle\Service\Toolbox;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Toolbox::class)]
final class ToolboxTest extends TestCase
{
  private Toolbox $toolbox;

  public function setUp(): void
  {
    $this->toolbox = new Toolbox();
  }

  #[DataProvider('wrapperProvider')]
  public function testWrapper($wrapper)
  {
    $result = $this->toolbox->isWrapper($wrapper);
    $this->assertTrue($result);
  }

  public static function wrapperProvider(): array
  {
    return [
      ['compress.bzip2://file.bz2'],
      ['zip://archive.zip#dir/file.txt'],
      ['file:///path/to/file.ext'],
      ['glob://ext/spl/examples/*.php'],
      ['php://stdout'],
      ['http://example.com/file.php?var1=val1&var2=val2'],
      ['ssh2.tunnel://user:pass@example.com:22/192.168.0.1:14'],
      ['var://myvar'],
      ['foo+bar://myvar'],
      ['foo-bar://myvar'],
      ['x://myvar'],
    ];
  }

  #[DataProvider('invalidWrapperProvider')]
  public function testInvalidWrapper($wrapper)
  {
    $result = $this->toolbox->isWrapper($wrapper);
    $this->assertFalse($result);
  }

  public static function invalidWrapperProvider(): array
  {
    return [
      ['compress.bzip2'],
      ['zip:/archive.zip#dir/file.txt'],
      ['file:path/to/file.ext'],
      ['foo bar'],
      ['://foo'],
      ['@#://foo'],
    ];
  }

  #[DataProvider('appendExtensionProvider')]
  public function testAppendExtension($filename, $extension, $expected): void
  {
    $result = $this->toolbox->appendExtension($filename, $extension);
    $this->assertEquals($expected, $result);
  }

  public static function appendExtensionProvider()
  {
    return [
      ['hello.php', 'php', 'hello.php'],
      ['hello', 'php', 'hello.php'],
      ['hello.php', 'mp3', 'hello.php.mp3'],
    ];
  }

  #[DataProvider('appendInvalidExtensionProvider')]
  public function testInvalidAppendExtension($filename, $extension): void
  {
    $this->expectException(RuntimeException::class);
    $this->toolbox->appendExtension($filename, $extension);
  }

  public static function appendInvalidExtensionProvider()
  {
    return [
      ['', 'php'],
      ['  ', 'php'],
      ["\t", 'php'],
      ['database', ''],
      ['database', '  '],
      ['database', "\t"],
      ["\t", "\t"],
      ["  ", "  "],
    ];
  }

  #[DataProvider('isValidFormatProvider')]
  public function testIsValidFormat($format)
  {
    $result = $this->toolbox->isValidFormat($format);
    $this->assertTrue($result);
  }

  public static function isValidFormatProvider()
  {
    return [
      ['puml'],
      ['svg'],
      ['png'],
    ];
  }

  #[DataProvider('isInvalidFormatProvider')]
  public function testIsInvalidFormat($format)
  {
    $result = $this->toolbox->isValidFormat($format);
    $this->assertFalse($result);
  }

  public static function isInvalidFormatProvider()
  {
    return [
      [''],
      ["\t"],
      ['txt'],
      ['abc'],
      ['0'],
      ['latex'],
      ['pdf'],
    ];
  }


}
