<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Sanitizer\Laravel\Factory;
use Sanitizer\Sanitizer;

class FactoryTest extends TestCase
{
    public function sanitize($data, $rules)
    {
        $sanitizer = new Sanitizer($data, $rules, [
            'capitalize' => \Sanitizer\Filters\Capitalize::class,
            'escape' => \Sanitizer\Filters\EscapeHTML::class,
            'format_date' => \Sanitizer\Filters\FormatDate::class,
            'lowercase' => \Sanitizer\Filters\Lowercase::class,
            'uppercase' => \Sanitizer\Filters\Uppercase::class,
            'trim' => \Sanitizer\Filters\Trim::class,
        ]);

        return $sanitizer->sanitize();
    }

    public function testCustomClosureFilter()
    {
        $factory = new Factory();
        $factory->extend('hash', function ($value) {
            return sha1($value);
        });

        $data = [
            'name' => 'TEST',
        ];

        $rules = [
            'name' => 'hash',
        ];

        $newData = $factory->make($data, $rules)->sanitize();
        $this->assertSame(sha1('TEST'), $newData['name']);
    }

    public function testCustomClassFilter()
    {
        $factory = new Factory();
        $factory->extend('custom', CustomFilter::class);

        $data = [
            'name' => 'TEST',
        ];

        $rules = [
            'name' => 'custom',
        ];

        $newData = $factory->make($data, $rules)->sanitize();
        $this->assertSame('TESTTEST', $newData['name']);
    }

    public function testReplaceFilter()
    {
        $factory = new Factory();
        $factory->extend('trim', function ($value) {
            return sha1($value);
        });

        $data = [
            'name' => 'TEST',
        ];

        $rules = [
            'name' => 'trim',
        ];

        $newData = $factory->make($data, $rules)->sanitize();
        $this->assertSame(sha1('TEST'), $newData['name']);
    }
}
