<?php

/*
 * This file is part of AbstractLanguage library.
 *
 * (c) Guedel <guedel87@live.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

$fileHeaderParts = [
    <<<'EOF'
        This file is part of AbstractLanguage library.

        (c) Guedel <guedel87@live.fr>

        EOF,
    <<<'EOF'

        This source file is subject to the MIT license that is bundled
        with this source code in the file LICENSE.
        EOF,
];

$finder = PhpCsFixer\Finder::create()
  ->in("src")
  ->in("tests")
  ->append([
      __DIR__ . '/.php-cs-fixer.dist.php',
      __DIR__ . '/rector.php',
  ])
;

return (new PhpCsFixer\Config())
  // ->setIndent(str_pad(' ', 2))
  ->setRules([
    "@PSR12" => true,
    'header_comment' => [
      'header' => implode('', $fileHeaderParts),
    ]
  ])
  ->setFinder($finder);
