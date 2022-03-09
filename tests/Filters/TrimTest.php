<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Sanitizer\Test\SanitizerTrait;

class TrimTest extends TestCase
{
    use SanitizerTrait;

    public function testItTrimsStrings()
    {
        $data = [
            'name' => '  Test  ',
        ];

        $rules = [
            'name' => 'trim',
        ];

        $data = $this->sanitize($data, $rules);
        $this->assertSame('Test', $data['name']);
    }

    public function testItTrimReturnValueNoChange()
    {
        $data = [
            'name' => 123,
        ];

        $rules = [
            'name' => 'trim',
        ];

        $data = $this->sanitize($data, $rules);
        $this->assertSame(123, $data['name']);
    }
}
