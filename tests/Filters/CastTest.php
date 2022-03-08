<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Sanitizer\Test\SanitizerTrait;

class CastTest extends TestCase
{
    use SanitizerTrait;

    public function testItThrowsExceptionWhenNoCastTypeIsSet()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->sanitize(['name' => 'Name'], ['name' => 'cast']);
    }

    public function testItThrowsExceptionWhenNonExistingCastTypeIsSet()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->sanitize(['name' => 'Name'], ['name' => 'cast:bullshit']);
    }

    public function testItCastsToInteger()
    {
        $results = $this->sanitize(['var' => '15.6'], ['var' => 'cast:integer']);
        $this->assertIsInt($results['var']);
        $this->assertSame(15, $results['var']);
    }

    public function testItCastsToFloat()
    {
        $results = $this->sanitize(['var' => '15.6'], ['var' => 'cast:double']);
        $this->assertIsFloat($results['var']);
        $this->assertSame(15.6, $results['var']);
    }

    public function testItCastsToString()
    {
        $results = $this->sanitize(['var' => 15], ['var' => 'cast:string']);
        $this->assertIsString($results['var']);
        $this->assertSame('15', $results['var']);
    }

    public function testItCastsToBoolean()
    {
        $results = $this->sanitize(['var' => 15], ['var' => 'cast:boolean']);
        $this->assertIsBool($results['var']);
        $this->assertSame(true, $results['var']);
    }

    public function testItCastsArrayToObject()
    {
        $data = [
            'name' => 'Name',
            'cost' => 15.6,
        ];

        $encodedData = $data;
        $results = $this->sanitize(['var' => $encodedData], ['var' => 'cast:object']);
        $this->assertInstanceOf('stdClass', $results['var']);
        $this->assertSame('Name', $results['var']->name);
        $this->assertSame(15.6, $results['var']->cost);
    }

    public function testItCastsJsonToObject()
    {
        $data = [
            'name' => 'Name',
            'cost' => 15.6,
        ];

        $encodedData = json_encode($data);
        $results = $this->sanitize(['var' => $encodedData], ['var' => 'cast:object']);
        $this->assertInstanceOf('stdClass', $results['var']);
        $this->assertSame('Name', $results['var']->name);
        $this->assertSame(15.6, $results['var']->cost);
    }

    public function testItCastsJsonToArray()
    {
        $data = [
            'name' => 'Name',
            'cost' => 15.6,
        ];

        $encodedData = json_encode($data);
        $results = $this->sanitize(['var' => $encodedData], ['var' => 'cast:array']);
        $this->assertIsArray($results['var']);
        $this->assertSame('Name', $results['var']['name']);
        $this->assertSame(15.6, $results['var']['cost']);
    }

    public function testItCastsArrayToCollection()
    {
        $data = [
            'name' => 'Name',
            'cost' => 15.6,
        ];

        $encodedData = $data;
        $results = $this->sanitize(['var' => $encodedData], ['var' => 'cast:collection']);
        $this->assertInstanceOf('\Illuminate\Support\Collection', $results['var']);
        $this->assertSame('Name', $results['var']->first());
    }

    public function testItCastsJsonToCollection()
    {
        $data = [
            'name' => 'Name',
            'cost' => 15.6,
        ];

        $encodedData = json_encode($data);
        $results = $this->sanitize(['var' => $encodedData], ['var' => 'cast:collection']);
        $this->assertInstanceOf('\Illuminate\Support\Collection', $results['var']);
        $this->assertSame('Name', $results['var']->first());
    }
}
