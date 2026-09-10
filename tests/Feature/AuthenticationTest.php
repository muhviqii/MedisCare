<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_correct_credentials(): void
    {
        $role = Role::factory()->create(['slug' => 'admin_rs']);
        $user = User::factory()->create(['password' => bcrypt('Password123'), 'role_id' => $role->id]);

        $response = $this->post('/login', ['email' => $user->email, 'password' => 'Password123']);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_wrong_password(): void
    {
        $user = User::factory()->create(['password' => bcrypt('Password123')]);

        $response = $this->post('/login', ['email' => $user->email, 'password' => 'salah']);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_inactive_user_cannot_login(): void
    {
        $user = User::factory()->create(['password' => bcrypt('Password123'), 'is_active' => false]);

        $response = $this->post('/login', ['email' => $user->email, 'password' => 'Password123']);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_is_rate_limited_after_too_many_attempts(): void
    {
        $user = User::factory()->create(['password' => bcrypt('Password123')]);

        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', ['email' => $user->email, 'password' => 'salah']);
        }

        $response = $this->post('/login', ['email' => $user->email, 'password' => 'salah']);

        $response->assertSessionHasErrors('email');
    }
}
