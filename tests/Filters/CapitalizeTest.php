<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Sanitizer\Sanitizer;

class CapitalizeTest extends TestCase
{
    /**
     * @param $data
     * @param $rules
     *
     * @return mixed
     */
    public function sanitize($data, $rules)
    {
        $sanitizer = new Sanitizer($data, $rules);

        return $sanitizer->sanitize();
    }

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
