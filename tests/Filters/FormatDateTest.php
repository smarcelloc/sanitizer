<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Sanitizer\Test\SanitizerTrait;

class FormatDateTest extends TestCase
{
    use SanitizerTrait;

    public function testItFormatsDates()
    {
        $data = [
            'name' => '21/03/1983',
        ];

        $rules = [
            'name' => 'fdate:d/m/Y, Y-m-d',
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
            'name' => 'fdate:d/m/Y',
        ];

        $data = $this->sanitize($data, $rules);
    }
}
