<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Sanitizer\Test\SanitizerTrait;

class LowercaseTest extends TestCase
{
    use SanitizerTrait;

    public function testItLowercasesStrings()
    {
        $data = [
            'name' => 'HellO EverYboDy',
        ];

        $rules = [
            'name' => 'lowercase',
        ];

        $data = $this->sanitize($data, $rules);
        $this->assertSame('hello everybody', $data['name']);
    }

    public function testItLowercasesSpecialCharactersStrings()
    {
        $data = [
            'name' => 'Τάχιστη αλώπηξ',
        ];

        $rules = [
            'name' => 'lowercase',
        ];

        $data = $this->sanitize($data, $rules);
        $this->assertSame('τάχιστη αλώπηξ', $data['name']);
    }
}
