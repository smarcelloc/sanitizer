<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Sanitizer\Sanitizer;

class TrimTest extends TestCase
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
}
