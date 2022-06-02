<?php

declare(strict_types=1);

$config = new PhpCsFixer\Config();
$header = <<<EOF
This file is part of the imap-tester package.
(c) Jeffrey Boehm <https://github.com/jeboehm/imap-tester>
For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

return $config
    ->setRules([
                   '@PSR2' => true,
                   '@Symfony' => true,
                   '@PHP80Migration' => true,
                   'header_comment' => ['header' => $header, 'separate' => 'bottom', 'comment_type' => 'PHPDoc'],
                   'no_useless_else' => true,
                   'no_useless_return' => true,
                   'ordered_class_elements' => true,
                   'ordered_imports' => true,
                   'phpdoc_order' => true,
                   'concat_space' => ['spacing' => 'one'],
                   'array_syntax' => ['syntax' => 'short'],
                   'declare_strict_types' => true,
               ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude('vendor')
            ->in(__DIR__ . '/bin')
            ->in(__DIR__ . '/src')
    );
