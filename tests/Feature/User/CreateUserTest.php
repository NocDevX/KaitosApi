<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @param array $parameters
     * @return void
     */
    #[DataProvider('provideValidData')]
    public function test_try_to_create_user_should_succeed(array $parameters): void
    {
        $response = $this->post('api/user/create', $parameters);
        $response->assertStatus(201);
    }

    /**
     * @return array[]
     */
    public static function provideValidData(): array
    {
        return [
            'valid_parameters' => [[
                'name' => fake()->name,
                'email' => fake()->safeEmail,
                'password' => 'strongPass1234!@#$'
            ]]
        ];
    }
}
