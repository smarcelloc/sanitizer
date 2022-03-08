<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Sanitizer\Test\SanitizerTrait;

class CapitalizeTest extends TestCase
{
    use SanitizerTrait;

    public function testItCapitalizesStrings()
    {
        $result = $this->sanitize(['name' => ' jon snow 145'], ['name' => 'capitalize']);
        $this->assertSame(' Jon Snow 145', $result['name']);
    }

    public function testItCapitalizesSpecialCharacters()
    {
        $result = $this->sanitize(['name' => 'Τάχιστη αλώπηξ'], ['name' => 'capitalize']);
        $this->assertSame('Τάχιστη Αλώπηξ', $result['name']);
    }
}
