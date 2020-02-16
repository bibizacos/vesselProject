<?php

namespace Tests\Feature;

use App\Http\Resources\ApiV1;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiV1Test extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testBody()
    {
        ApiV1::getVessels();
        $this->assertTrue($box->has('toy'));
        $this->assertFalse($box->has('ball'));
    }

}
