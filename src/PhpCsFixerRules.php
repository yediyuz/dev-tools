<?php

declare(strict_types=1);

namespace Yediyuz\DevTools;

use Illuminate\Support\Collection;

class PhpCsFixerRules
{
    private array|Collection $rules = [
        '@Symfony'                                      => true,
        'phpdoc_no_empty_return'                        => false,
        'single_trait_insert_per_statement'             => true,
        'array_syntax'                                  => ['syntax' => 'short'],
        'binary_operator_spaces'                        => [
            'default'   => 'single_space',
            'operators' => [
                '=>' => 'align',
                '|'  => 'no_space',
            ],
        ],
        'not_operator_with_space'                       => false,
        'blank_line_after_namespace'                    => true,
        'blank_line_after_opening_tag'                  => true,
        'blank_line_before_statement'                   => [
            'statements' => ['break', 'continue', 'declare', 'return', 'throw', 'try'],
        ],
        'braces'                                        => true,
        'cast_spaces'                                   => true,
        'class_attributes_separation'                   => [
            'elements' => [
                'const'        => 'one',
                'method'       => 'one',
                'property'     => 'one',
                'trait_import' => 'none',
            ],
        ],
        'class_definition'                              => [
            'multi_line_extends_each_single_line' => true, 'single_item_single_line' => true, 'single_line' => true,
        ],
        'concat_space'                                  => ['spacing' => 'one'],
        'constant_case'                                 => ['case' => 'lower'],
        'declare_equal_normalize'                       => true,
        'elseif'                                        => true,
        'encoding'                                      => true,
        'full_opening_tag'                              => true,
        'fully_qualified_strict_types'                  => true,
        'function_declaration'                          => true,
        'function_typehint_space'                       => true,
        'general_phpdoc_tag_rename'                     => true,
        'heredoc_to_nowdoc'                             => true,
        'include'                                       => true,
        'increment_style'                               => ['style' => 'post'],
        'indentation_type'                              => true,
        'line_ending'                                   => true,
        'linebreak_after_opening_tag'                   => true,
        'list_syntax'                                   => true,
        'lowercase_cast'                                => true,
        'lowercase_keywords'                            => true,
        'lowercase_static_reference'                    => true,
        'magic_constant_casing'                         => true,
        'magic_method_casing'                           => true,
        'method_argument_space'                         => [
            'on_multiline'                     => 'ensure_fully_multiline',
            'keep_multiple_spaces_after_comma' => true,
        ],
        'multiline_whitespace_before_semicolons'        => ['strategy' => 'no_multi_line'],
        'native_function_casing'                        => true,
        'no_blank_lines_after_class_opening'            => true,
        'no_blank_lines_after_phpdoc'                   => true,
        'no_closing_tag'                                => true,
        'no_empty_phpdoc'                               => true,
        'no_empty_statement'                            => true,
        'no_extra_blank_lines'                          => ['tokens' => ['extra', 'throw', 'use']],
        'no_leading_import_slash'                       => true,
        'no_leading_namespace_whitespace'               => true,
        'no_mixed_echo_print'                           => ['use' => 'echo'],
        'no_multiline_whitespace_around_double_arrow'   => true,
        'no_short_bool_cast'                            => true,
        'no_singleline_whitespace_before_semicolons'    => true,
        'no_spaces_after_function_name'                 => true,
        'no_spaces_around_offset'                       => ['positions' => ['inside', 'outside']],
        'no_spaces_inside_parenthesis'                  => true,
        'no_trailing_comma_in_singleline'               => [
            'elements' => [
                'arguments',
                'array_destructuring',
                'array',
                'group_import',
            ],
        ],
        'no_trailing_whitespace'                        => true,
        'no_trailing_whitespace_in_comment'             => true,
        'no_unneeded_control_parentheses'               => [
            'statements' => [
                'break', 'clone', 'continue', 'echo_print', 'return', 'switch_case', 'yield',
            ],
        ],
        'no_unused_imports'                             => true,
        'no_useless_return'                             => true,
        'no_whitespace_before_comma_in_array'           => true,
        'no_whitespace_in_blank_line'                   => true,
        'normalize_index_brace'                         => true,
        'not_operator_with_successor_space'             => true,
        'object_operator_without_whitespace'            => true,
        'ordered_imports'                               => ['sort_algorithm' => 'alpha'],
        'phpdoc_indent'                                 => true,
        'phpdoc_inline_tag_normalizer'                  => true,
        'phpdoc_no_access'                              => true,
        'phpdoc_no_package'                             => true,
        'phpdoc_no_useless_inheritdoc'                  => true,
        'phpdoc_order'                                  => true,
        'phpdoc_scalar'                                 => true,
        'phpdoc_single_line_var_spacing'                => true,
        'phpdoc_summary'                                => true,
        'phpdoc_tag_type'                               => true,
        'phpdoc_to_comment'                             => false,
        'phpdoc_trim'                                   => true,
        'phpdoc_types'                                  => true,
        'phpdoc_var_without_name'                       => true,
        'phpdoc_annotation_without_dot'                 => true,
        'phpdoc_trim_consecutive_blank_line_separation' => false,
        'phpdoc_var_annotation_correct_order'           => true,
        'short_scalar_cast'                             => true,
        'single_blank_line_at_eof'                      => true,
        'single_blank_line_before_namespace'            => true,
        'single_import_per_statement'                   => true,
        'single_line_after_imports'                     => true,
        'single_line_comment_style'                     => ['comment_types' => ['hash']],
        'single_quote'                                  => true,
        'space_after_semicolon'                         => true,
        'standardize_not_equals'                        => true,
        'switch_case_semicolon_to_colon'                => true,
        'switch_case_space'                             => true,
        'ternary_operator_spaces'                       => true,
        'trailing_comma_in_multiline'                   => ['elements' => ['arrays']],
        'trim_array_spaces'                             => true,
        'unary_operator_spaces'                         => true,
        'visibility_required'                           => ['elements' => ['property', 'method', 'const']],
        'whitespace_after_comma_in_array'               => true,
        'yoda_style'                                    => false,
        'new_with_braces'                               => false,
    ];

    public function set(string $rulePath, mixed $value): static
    {
        data_set($this->rules, $rulePath, $value);

        return $this;
    }

    public function forget(string $rulePath): static
    {
        $this->rules = collect($this->rules)->forget($rulePath);

        return $this;
    }

    public function toCollection(): static
    {
        $this->rules = collect($this->rules);

        return $this;
    }

    public function get(): array
    {
        return is_array($this->rules) ? $this->rules : $this->rules->toArray();
    }
}