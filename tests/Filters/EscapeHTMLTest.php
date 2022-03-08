<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Sanitizer\Test\SanitizerTrait;

class EscapeHTMLTest extends TestCase
{
    use SanitizerTrait;

    public function testItEscapesStrings()
    {
        $data = [
            'name' => '<h1>Hello! Unicode chars as Ñ are not escaped.</h1> <script>Neither is content inside HTML tags</script>',
        ];

        $rules = [
            'name' => 'escape',
        ];

        $data = $this->sanitize($data, $rules);
        $this->assertSame('&lt;h1&gt;Hello! Unicode chars as Ñ are not escaped.&lt;/h1&gt; &lt;script&gt;Neither is content inside HTML tags&lt;/script&gt;', $data['name']);
    }
}
