<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;

class ApiUserUsernameTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function must_return_404_code()
    {
        $response = $this->get(route('api_v1.user.get_username', [
            'apikey' => Str::random(10),
        ]));

        $response->assertStatus(404);

        $response->assertJson([
            'message' => "User not found. Sorry!"
        ]);
    }

    /**
     * @test
     */
    public function must_return_302_code()
    {
        $response = $this->get(route('api_v1.user.get_username'));

        $response->assertStatus(302);

        $response->assertSessionHasErrors([
            // 'apikey' => 'The apikey field is required.', //is not desired
        ]);
    }

    /**
     * @test
     */
    public function must_return_the_user_info()
    {
        $user = User::factory()->createOne();

        $response = $this->get(route('api_v1.user.get_username', [
            'apikey' => $user->api_key,
        ]));

        $response->assertStatus(200);

        $response->assertJson([
            'username' => $user->username,
            'country' => $user->country,
            'phone' => $user->phone,
            'api_key' => $user->api_key,
        ]);
    }
}
