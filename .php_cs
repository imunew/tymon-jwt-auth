<?php
$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__.'/src',
    ])
    ->exclude([
    ])
;
return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2' => true,
        'error_suppression' => [
            'noise_remaining_usages' => true,
        ],
        'array_syntax' => ['syntax' => 'short'],
    ])
    ->setRiskyAllowed(true)
    ->setUsingCache(false)
    ->setFinder($finder)
    ;