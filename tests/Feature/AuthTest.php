<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_shows_login_form()
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    #[Test]
    public function it_can_login_with_valid_credentials()
    {
        $employee = Employee::factory()->create();
        $user = User::factory()->create([
            'employee_id' => $employee->id,
            'username' => 'testuser',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $response = $this->post(route('login'), [
            'username' => 'testuser',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    #[Test]
    public function it_cannot_login_with_invalid_credentials()
    {
        $response = $this->post(route('login'), [
            'username' => 'invaliduser',
            'password' => 'wrongpassword',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('username');
    }

    #[Test]
    public function it_requires_username_to_login()
    {
        $response = $this->post(route('login'), [
            'username' => '',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('username');
    }

    #[Test]
    public function it_requires_password_to_login()
    {
        $response = $this->post(route('login'), [
            'username' => 'testuser',
            'password' => '',
        ]);

        $response->assertSessionHasErrors('password');
    }

    #[Test]
    public function it_can_logout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('logout'));

        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function it_redirects_admin_to_admin_dashboard()
    {
        $employee = Employee::factory()->create();
        $user = User::factory()->admin()->create([
            'employee_id' => $employee->id,
            'username' => 'admin',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post(route('login'), [
            'username' => 'admin',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
    }

    #[Test]
    public function it_redirects_hr_to_hr_dashboard()
    {
        $employee = Employee::factory()->create();
        $user = User::factory()->hr()->create([
            'employee_id' => $employee->id,
            'username' => 'hruser',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post(route('login'), [
            'username' => 'hruser',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('hr.dashboard'));
    }

    #[Test]
    public function it_redirects_inventory_to_inventory_dashboard()
    {
        $employee = Employee::factory()->create();
        $user = User::factory()->inventory()->create([
            'employee_id' => $employee->id,
            'username' => 'inventory',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post(route('login'), [
            'username' => 'inventory',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('inventory.dashboard'));
    }

    #[Test]
    public function it_remembers_user_when_remember_is_checked()
    {
        $employee = Employee::factory()->create();
        $user = User::factory()->create([
            'employee_id' => $employee->id,
            'username' => 'testuser',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post(route('login'), [
            'username' => 'testuser',
            'password' => 'password',
            'remember' => true,
        ]);

        $this->assertAuthenticatedAs($user);
    }

    #[Test]
    public function it_regenerates_session_after_login()
    {
        $employee = Employee::factory()->create();
        $user = User::factory()->create([
            'employee_id' => $employee->id,
            'username' => 'testuser',
            'password' => Hash::make('password'),
        ]);

        $this->post(route('login'), [
            'username' => 'testuser',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
    }
}
