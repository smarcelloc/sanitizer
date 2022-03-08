<?php

declare(strict_types=1);

$rules = [
    '@PSR12:risky' => true,
    '@Symfony' => true,
    'psr_autoloading' => true, // risky
    'declare_strict_types' => true, // risky
    'php_unit_test_annotation' => true, // risky
    'php_unit_strict' => true, // risky
    'strict_comparison' => true, // risky
    'concat_space' => ['spacing' => 'one'],
    'declare_parentheses' => true,
    'yoda_style' => false,
    'align_multiline_comment' => true,
    'array_indentation' => true,
    'combine_consecutive_issets' => true,
    'combine_consecutive_unsets' => true,
    'explicit_string_variable' => true,
    'method_chaining_indentation' => true,
    'multiline_comment_opening_closing' => true,
    'multiline_whitespace_before_semicolons' => true,
    'no_superfluous_elseif' => true,
    'no_useless_else' => true,
    'no_useless_return' => true,
    'operator_linebreak' => true,
    'simple_to_complex_string_variable' => true,
    'phpdoc_add_missing_param_annotation' => true,
    'phpdoc_var_annotation_correct_order' => true,
    'phpdoc_order' => true,
    'self_static_accessor' => true,
    'control_structure_continuation_position' => true,
    'global_namespace_import' => [
        'import_classes' => false,
        'import_constants' => false,
        'import_functions' => false,
    ],
    'ordered_class_elements' => [
        'order' => [
            'use_trait',
            'constant',
            'property',
            'magic',
            'method',
        ],
    ],
    'blank_line_before_statement' => [
        'statements' => [
            'case',
            'default',
            'do',
            'exit',
            'for',
            'foreach',
            'if',
            'return',
            'switch',
            'throw',
            'try',
            'while',
        ],
    ],
];

$finder = PhpCsFixer\Finder::create()->in(__DIR__);

$config = new PhpCsFixer\Config();
$config->setRules($rules)
    ->setRiskyAllowed(true)
    ->setFinder($finder);

return $config;
