<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('login', [
            "email" => "test@example.com",
            "password" => "password",
        ])
            ->assertSeeText("PENDAPATAN BULAN INI");
    }
}
