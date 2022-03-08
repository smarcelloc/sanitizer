<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Sanitizer\Sanitizer;

class UppercaseTest extends TestCase
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

    public function testItUppercasesStrings()
    {
        $data = [
            'name' => 'HellO EverYboDy',
        ];

        $rules = [
            'name' => 'uppercase',
        ];

        $data = $this->sanitize($data, $rules);
        $this->assertSame('HELLO EVERYBODY', $data['name']);
    }

    public function testItUppercasesSpecialCharactersStrings()
    {
        $data = [
            'name' => 'Τάχιστη αλώπηξ',
        ];

        $rules = [
            'name' => 'uppercase',
        ];

        $data = $this->sanitize($data, $rules);
        $this->assertSame('ΤΆΧΙΣΤΗ ΑΛΏΠΗΞ', $data['name']);
    }
}
