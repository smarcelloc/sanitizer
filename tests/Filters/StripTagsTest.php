<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Sanitizer\Test\SanitizerTrait;

class StripTagsTest extends TestCase
{
    use SanitizerTrait;

    public function testItTrimsStrings()
    {
        $data = [
            'name' => '<p>Test paragraph.</p><!-- Comment --> <a href="#fragment">Other text</a>',
        ];

        $rules = [
            'name' => 'strip_tags',
        ];

        $data = $this->sanitize($data, $rules);
        $this->assertSame('Test paragraph. Other text', $data['name']);
    }
}
