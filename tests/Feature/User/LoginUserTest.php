<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_try_to_login_user_should_succeed(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password')
        ]);

        $this->post('/api/user/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
    }
}
