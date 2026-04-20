<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthRoleRedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_registered_users_are_created_as_customers_and_redirected_to_customer_dashboard(): void
    {
        $response = $this->post('/register', [
            'name' => 'Riski Customer',
            'email' => 'customer@example.com',
            'phone' => '081234567890',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('dashboard', absolute: false));
        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'email' => 'customer@example.com',
            'role' => User::ROLE_CUSTOMER,
            'status' => User::STATUS_ACTIVE,
        ]);
    }

    public function test_admin_login_is_redirected_to_admin_dashboard(): void
    {
        $admin = User::factory()->admin()->create([
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard', absolute: false));
        $this->assertAuthenticatedAs($admin);
    }
}
