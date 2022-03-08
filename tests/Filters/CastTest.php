<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Sanitizer\Sanitizer;

class CastTest extends TestCase
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

    /**
     *  @test
     */
    public function itThrowsExceptionWhenNoCastTypeIsSet()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->sanitize(['name' => 'Name'], ['name' => 'cast']);
    }

    /**
     *  @test
     */
    public function itThrowsExceptionWhenNonExistingCastTypeIsSet()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->sanitize(['name' => 'Name'], ['name' => 'cast:bullshit']);
    }

    /**
     *  @test
     */
    public function itCastsToInteger()
    {
        $results = $this->sanitize(['var' => '15.6'], ['var' => 'cast:integer']);
        $this->assertIsInt($results['var']);
        $this->assertEquals(15, $results['var']);
    }

    /**
     *  @test
     */
    public function itCastsToFloat()
    {
        $results = $this->sanitize(['var' => '15.6'], ['var' => 'cast:double']);
        $this->assertIsFloat($results['var']);
        $this->assertEquals(15.6, $results['var']);
    }

    /**
     *  @test
     */
    public function itCastsToString()
    {
        $results = $this->sanitize(['var' => 15], ['var' => 'cast:string']);
        $this->assertIsString($results['var']);
        $this->assertEquals('15', $results['var']);
    }

    /**
     *  @test
     */
    public function itCastsToBoolean()
    {
        $results = $this->sanitize(['var' => 15], ['var' => 'cast:boolean']);
        $this->assertIsBool($results['var']);
        $this->assertEquals(true, $results['var']);
    }

    /**
     *  @test
     */
    public function itCastsArrayToObject()
    {
        $data = [
            'name' => 'Name',
            'cost' => 15.6,
        ];
        $encodedData = $data;
        $results = $this->sanitize(['var' => $encodedData], ['var' => 'cast:object']);
        $this->assertInstanceOf('stdClass', $results['var']);
        $this->assertEquals('Name', $results['var']->name);
        $this->assertEquals(15.6, $results['var']->cost);
    }

    /**
     *  @test
     */
    public function itCastsJsonToObject()
    {
        $data = [
            'name' => 'Name',
            'cost' => 15.6,
        ];
        $encodedData = json_encode($data);
        $results = $this->sanitize(['var' => $encodedData], ['var' => 'cast:object']);
        $this->assertInstanceOf('stdClass', $results['var']);
        $this->assertEquals('Name', $results['var']->name);
        $this->assertEquals(15.6, $results['var']->cost);
    }

    /**
     *  @test
     */
    public function itCastsJsonToArray()
    {
        $data = [
            'name' => 'Name',
            'cost' => 15.6,
        ];
        $encodedData = json_encode($data);
        $results = $this->sanitize(['var' => $encodedData], ['var' => 'cast:array']);
        $this->assertIsArray($results['var']);
        $this->assertEquals('Name', $results['var']['name']);
        $this->assertEquals(15.6, $results['var']['cost']);
    }

    /**
     *  @test
     */
    public function itCastsArrayToCollection()
    {
        $data = [
            'name' => 'Name',
            'cost' => 15.6,
        ];
        $encodedData = $data;
        $results = $this->sanitize(['var' => $encodedData], ['var' => 'cast:collection']);
        $this->assertInstanceOf('\Illuminate\Support\Collection', $results['var']);
        $this->assertEquals('Name', $results['var']->first());
    }

    /**
     *  @test
     */
    public function itCastsJsonToCollection()
    {
        $data = [
            'name' => 'Name',
            'cost' => 15.6,
        ];
        $encodedData = json_encode($data);
        $results = $this->sanitize(['var' => $encodedData], ['var' => 'cast:collection']);
        $this->assertInstanceOf('\Illuminate\Support\Collection', $results['var']);
        $this->assertEquals('Name', $results['var']->first());
    }
}
