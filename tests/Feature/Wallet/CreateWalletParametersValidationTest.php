<?php

namespace Tests\Feature\Wallet;

use App\Http\Requests\CreateWalletRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class CreateWalletParametersValidationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @param mixed $parameters
     * @return void
     */
    #[DataProvider('provideValidParameters')]
    public function test_should_succeed_when_sent_parameters_are_valid(mixed $parameters): void
    {
        $request = new CreateWalletRequest();
        $validator = Validator::make($parameters, $request->rules());
        $this->assertTrue($validator->passes());
    }

    /**
     * @param mixed $parameters
     * @return void
     */
    #[DataProvider('provideInvalidParameters')]
    public function test_should_fail_when_sent_parameters_are_invalid(mixed $parameters): void
    {
        $request = new CreateWalletRequest();
        $validator = Validator::make($parameters, $request->rules());
        $this->assertTrue($validator->fails());
    }

    /**
     * @return array[]
     */
    public static function provideValidParameters(): array
    {
        return [
            'has_a_valid_lenght' => [[
                'name' => fake()->text(64)
            ]]
        ];
    }

    /**
     * @return array[]
     */
    public static function provideInvalidParameters(): array
    {
        return [
            'no_parameters_provided' => [[]],
            'name_is_over_accepted_lenght' => [[
                'name' => Str::random(65)
            ]],
            'name_is_an_integer' => [[
                'name' => fake()->numberBetween()
            ]],
            'name_is_an_array' => [[
                'name' => []
            ]],
        ];
    }
}
