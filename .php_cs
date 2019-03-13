<?php

$finder = PhpCsFixer\Finder::create()
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true)
    ->notPath('cache')
    ->notPath('vendor');

return PhpCsFixer\Config::create()
    ->setLineEnding("\n")
    ->setRules([
        '@PSR2' => true, //https://github.com/FriendsOfPHP/PHP-CS-Fixer/blob/master/src/RuleSet.php
        'function_declaration' => [
            'closure_function_spacing' => 'none',//Spaces => Before Parentheses => Anonymous function parentheses
        ],
        /* Array */
        'array_syntax' => [
            'syntax' => 'short',
        ],
        'trailing_comma_in_multiline_array' => true,
        'no_trailing_comma_in_singleline_array' => true,
        /* Array */
        /* List */
        'list_syntax' => [
            'syntax' => 'short',
        ],
        /* List */
        /* Imports */
        'ordered_imports' => [
            'sortAlgorithm' => 'alpha',
        ],
        'no_unused_imports' => true,
        /* Imports */
    ])
    ->setFinder($finder)
    ->setUsingCache(false);
