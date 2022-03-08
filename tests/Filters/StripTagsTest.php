<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Sanitizer\Sanitizer;

class StripTagsTest extends TestCase
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
            'name' => '<p>Test paragraph.</p><!-- Comment --> <a href="#fragment">Other text</a>',
        ];

        $rules = [
            'name' => 'strip_tags',
        ];

        $data = $this->sanitize($data, $rules);
        $this->assertSame('Test paragraph. Other text', $data['name']);
    }
}
