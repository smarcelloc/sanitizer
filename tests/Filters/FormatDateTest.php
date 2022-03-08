<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Sanitizer\Sanitizer;

class FormatDateTest extends TestCase
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

    public function testItFormatsDates()
    {
        $data = [
            'name' => '21/03/1983',
        ];

        $rules = [
            'name' => 'format_date:d/m/Y, Y-m-d',
        ];

        $data = $this->sanitize($data, $rules);
        $this->assertSame('1983-03-21', $data['name']);
    }

    public function testItRequiresTwoArguments()
    {
        $this->expectException(\InvalidArgumentException::class);
        $data = [
            'name' => '21/03/1983',
        ];

        $rules = [
            'name' => 'format_date:d/m/Y',
        ];

        $data = $this->sanitize($data, $rules);
    }
}
