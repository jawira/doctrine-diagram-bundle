<?php declare(strict_types=1);
$config = new PhpCsFixer\Config();

// https://cs.symfony.com/doc/rules/index.html
$rules = [
  'braces' => true,
  'declare_strict_types' => true,
  'explicit_string_variable' => true,
  'heredoc_to_nowdoc' => true,
  'no_binary_string' => true,
  'no_trailing_whitespace' => true,
  'no_unused_imports' => true,
  'simple_to_complex_string_variable' => true,
  'simplified_if_return' => true,
  'single_blank_line_at_eof' => true,
  'single_quote' => true,
  'switch_case_space' => true,
  'octal_notation' => true,
];

return $config->setRules($rules)->setHideProgress(true)->setIndent('  ');
