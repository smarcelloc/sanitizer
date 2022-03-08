<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Sanitizer\Sanitizer;

class FilterIfTest extends TestCase
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

    public function testItApplyFilterIfMatch()
    {
        $data = [
            'name' => 'HellO EverYboDy',
        ];

        $rules = [
            'name' => 'uppercase|filter_if:name,HellO EverYboDy',
        ];

        $data = $this->sanitize($data, $rules);
        $this->assertSame('HELLO EVERYBODY', $data['name']);
    }

    public function testItDoesNotApplyFilterIfNoMatch()
    {
        $data = [
            'name' => 'HellO EverYboDy',
        ];

        $rules = [
            'name' => 'uppercase|filter_if:name,no match',
        ];

        $data = $this->sanitize($data, $rules);
        $this->assertSame('HellO EverYboDy', $data['name']);
    }
}
