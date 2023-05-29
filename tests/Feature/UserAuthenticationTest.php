<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        ob_end_clean(); # Temporary workaround. Not sure why there is an unclosed output buffer
    }
    
    public function test_users_cannot_log_in_with_invalid_password()
    {
        $this->post('/login', [
            'userid' => User::factory()->create()->userid,
            'password' => 'wrong-password',
        ]);
        $this->assertGuest();
    }

    public function test_users_can_log_in_and_log_out()
    {
        $response = $this->post('/login', [
            'userid' => User::factory()->create()->userid,
            'password' => 'password'
        ]);
        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);

        $response = $this->post('/logout');
        $this->assertGuest();
        $response->assertRedirect(env('APP_URL'));
    }
}
