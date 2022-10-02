<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $request = $this->postJson('/users/forgot_password', [
            'email' => 'testemail@terra.com'
        ]);
        $request->assertStatus(200);
    }
}
