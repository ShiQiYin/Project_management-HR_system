<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdatePasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_password_screen_can_be_rendered()
    {
        $this->post('/login', [
            'userid' => ($user = User::factory()->create())->userid,
            'password' => 'password'
        ]);
        $response = $this->get(RouteServiceProvider::HOME . "/users/{$user->id}/edit");
        $response->assertStatus(200);
    }
}
