<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Sanitizer\Test\SanitizerTrait;

class SanitizerTest extends TestCase
{
    use SanitizerTrait;

    public function testCombineFilters()
    {
        $data = [
            'name' => '  HellO EverYboDy   ',
        ];

        $rules = [
            'name' => 'trim|capitalize',
        ];

        $data = $this->sanitize($data, $rules);
        $this->assertSame('Hello Everybody', $data['name']);
    }

    public function testInputUnchangedIfNoFilter()
    {
        $data = [
            'name' => '  HellO EverYboDy   ',
        ];

        $rules = [
            'name' => '',
        ];

        $data = $this->sanitize($data, $rules);
        $this->assertSame('  HellO EverYboDy   ', $data['name']);
    }

    public function testArrayFilters()
    {
        $data = [
            'name' => '  HellO EverYboDy   ',
        ];

        $rules = [
            'name' => ['trim', 'capitalize'],
        ];

        $data = $this->sanitize($data, $rules);
        $this->assertSame('Hello Everybody', $data['name']);
    }

    public function testWildcardFilters()
    {
        $data = [
            'name' => [
                'first' => ' John ',
                'last' => ' Doe ',
            ],
            'address' => [
                'street' => ' Some street ',
                'city' => ' New York ',
            ],
        ];

        $rules = [
            'name.*' => 'trim',
            'address.city' => 'trim',
        ];

        $data = $this->sanitize($data, $rules);

        $sanitized = [
            'name' => ['first' => 'John', 'last' => 'Doe'],
            'address' => ['street' => ' Some street ', 'city' => 'New York'],
        ];

        $this->assertSame($sanitized, $data);
    }

    public function testItThrowsExceptionIfNonExistingFilter()
    {
        $this->expectException(InvalidArgumentException::class);
        $data = [
            'name' => '  HellO EverYboDy   ',
        ];

        $rules = [
            'name' => 'non-filter',
        ];

        $data = $this->sanitize($data, $rules);
    }

    public function testItShouldOnlySanitizePassedData()
    {
        $data = [
            'title' => ' Hello WoRlD ',
        ];

        $rules = [
            'title' => 'trim',
            'name' => 'trim|escape',
        ];

        $data = $this->sanitize($data, $rules);

        $this->assertArrayNotHasKey('name', $data);
        $this->assertArrayHasKey('title', $data);
        $this->assertSame(1, count($data));
    }

    public function testClosureRule()
    {
        $data = [
            'name' => ' Sina ',
        ];

        $rules = [
            'name' => ['trim', function ($value) {
                return strtoupper($value);
            }],
        ];

        $data = $this->sanitize($data, $rules);
        $this->assertSame('SINA', $data['name']);
    }
}
