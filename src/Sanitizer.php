<?php

declare(strict_types=1);

namespace Sanitizer;

use Illuminate\Support\Arr;
use Illuminate\Validation\ClosureValidationRule;
use Illuminate\Validation\ValidationRuleParser;

class Sanitizer
{
    /**
     * Data to sanitize.
     *
     * @var array
     */
    protected $data;

    /**
     * Filters to apply.
     *
     * @var array
     */
    protected $rules;

    /**
     * Available filters as $name => $classPath.
     *
     * @var array
     */
    protected $filters = [
        'title' => \Sanitizer\Filters\Title::class,
        'cast' => \Sanitizer\Filters\Cast::class,
        'escape' => \Sanitizer\Filters\EscapeHTML::class,
        'fdate' => \Sanitizer\Filters\FormatDate::class,
        'lower' => \Sanitizer\Filters\Lowercase::class,
        'upper' => \Sanitizer\Filters\Uppercase::class,
        'trim' => \Sanitizer\Filters\Trim::class,
        'strip_tags' => \Sanitizer\Filters\StripTags::class,
        'digit' => \Sanitizer\Filters\Digit::class,
        'if' => \Sanitizer\Filters\FilterIf::class,
    ];

    /**
     * Create a new sanitizer instance.
     */
    public function __construct(array $data, array $rules, array $customFilters = [])
    {
        $this->data = $data;
        $this->rules = $this->parseRules($rules);
        $this->filters = array_merge($this->filters, $customFilters);
    }

    /**
     *  Sanitize the given data.
     */
    public function sanitize(): array
    {
        $sanitized = $this->data;

        foreach ($this->rules as $attr => $rules) {
            if (Arr::has($this->data, $attr)) {
                $value = Arr::get($this->data, $attr);
                Arr::set($sanitized, $attr, $this->sanitizeValue($value, $rules));
            }
        }

        return $sanitized;
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    private function sanitizeValue($value, array $rules)
    {
        $original = $value;

        foreach ($rules as $rule) {
            if (is_array($rule) && $rule['name'] === 'if') {
                if (!$this->applyFilter($rule, $this->data)) {
                    return $original;
                }
            }

            $value = $this->applyFilter($rule, $value);
        }

        return $value;
    }

    /**
     *  Parse a rules array.
     */
    protected function parseRules(array $rules): array
    {
        $parsedRules = [];

        $rawRules = (new ValidationRuleParser($this->data))->explode($rules);

        foreach ($rawRules->rules as $attribute => $attributeRules) {
            foreach ($attributeRules as $attributeRule) {
                $parsedRule = $this->parseRule($attributeRule);

                if ($parsedRule) {
                    $parsedRules[$attribute][] = $parsedRule;
                }
            }
        }

        return $parsedRules;
    }

    /**
     * Parse a rule.
     *
     * @param mixed $rule
     *
     * @return array|\Closure
     */
    protected function parseRule($rule)
    {
        if (is_string($rule)) {
            return $this->parseRuleString($rule);
        }

        if ($rule instanceof ClosureValidationRule) {
            return $rule->callback;
        }

        throw new \InvalidArgumentException('Unsupported rule type.');
    }

    /**
     * Parse a rule string formatted as filterName:option1, option2 into an array formatted as [name => filterName, options => [option1, option2]].
     *
     * @param string $rule Formatted as 'filterName:option1, option2' or just 'filterName'
     *
     * @return array Formatted as [name => filterName, options => [option1, option2]]. Empty array if no filter name was found.
     */
    protected function parseRuleString($rule)
    {
        if (strpos($rule, ':') !== false) {
            [$name, $options] = explode(':', $rule, 2);
            $options = array_map('trim', explode(',', $options));
        } else {
            $name = $rule;
            $options = [];
        }

        if (!$name) {
            return [];
        }

        return compact('name', 'options');
    }

    /**
     * Apply the given filter by its name.
     *
     * @param array|\Closure $rule
     * @param mixed $value
     *
     * @return mixed
     */
    protected function applyFilter($rule, $value)
    {
        if ($rule instanceof \Closure) {
            return call_user_func($rule, $value);
        }

        $name = $rule['name'];
        $options = $rule['options'];

        // If the filter does not exist, throw an Exception:
        if (!isset($this->filters[$name])) {
            throw new \InvalidArgumentException("No filter found by the name of {$name}");
        }

        /** @var Filter|\Closure */
        $filter = $this->filters[$name];

        if ($filter instanceof \Closure) {
            return call_user_func_array($filter, [$value, $options]);
        }

        return (new $filter())->applyFilter($value, $options);
    }
}
