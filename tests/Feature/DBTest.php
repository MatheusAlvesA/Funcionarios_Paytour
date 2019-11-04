<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use DB;

class DBTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserPadrao()
    {
		$emails = DB::table('users')->select('email')->get();
		$this->assertTrue($emails[0]->email === 'matheuseejam@gmail.com');
		$this->assertTrue(count($emails) === 1);
    }
}
