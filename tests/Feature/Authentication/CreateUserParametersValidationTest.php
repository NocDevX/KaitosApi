<?php

namespace Tests\Feature\Authentication;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class CreateUserParametersValidationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_should_succeed_when_sent_parameters_are_valid(): void
    {
        $this->markTestIncomplete();
    }

    /**
     * @param mixed $parameters
     * @return void
     */
    #[DataProvider('provideInvalidParameters')]
    public function test_should_fail_when_sent_parameters_are_invalid(mixed $parameters): void
    {
        $response = $this->post('/api/user/create', $parameters);
        $response->assertStatus(422);
    }

    /**
     * @return array[]
     */
    public static function provideInvalidParameters(): array
    {
        return [
            'request_should_fail_when_no_parameters_are_provided' => [[]],
            'request_should_fail_when_missing_name' => [[
                'email' => 'thisEmailIsReal@gmail.com',
                'password' => 'aTotallyValidPassword1234$'
            ]],
            'request_should_fail_when_missing_email' => [[
                'name' => 'ACreatineUser',
                'password' => 'aTotallyValidPassword1234$'
            ]],
            'request_should_fail_when_missing_password' => [[
                'name' => 'ACreatineUser',
                'email' => 'thisEmailIsReal@gmail.com',
            ]],
        ];
    }
}
