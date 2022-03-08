<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Sanitizer\Test\SanitizerTrait;

class DigitTest extends TestCase
{
    use SanitizerTrait;

    public function testItStringToDigits()
    {
        $data = [
            'name' => '+08(096)90-123-45q',
        ];

        $rules = [
            'name' => 'digit',
        ];

        $data = $this->sanitize($data, $rules);
        $this->assertSame('080969012345', $data['name']);
    }

    public function testItStringToDigits2()
    {
        $data = [
            'name' => 'Qwe-rty!:)',
        ];

        $rules = [
            'name' => 'digit',
        ];

        $data = $this->sanitize($data, $rules);
        $this->assertSame('', $data['name']);
    }
}
