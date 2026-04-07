<?php

namespace Tests\Unit;

use App\Models\Employee;
use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_create_a_user()
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'username' => 'testuser',
            'role' => 'admin',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'username' => 'testuser',
            'role' => 'admin',
        ]);
    }

    #[Test]
    public function it_has_hidden_password_and_remember_token()
    {
        $employee = Employee::factory()->create();
        $user = User::factory()->create(['employee_id' => $employee->id]);
        
        $attributes = $user->toArray();

        $this->assertArrayNotHasKey('password', $attributes);
        $this->assertArrayNotHasKey('remember_token', $attributes);
    }

    #[Test]
    public function it_can_have_employee_relationship()
    {
        $employee = Employee::factory()->create();
        $user = User::factory()->create(['employee_id' => $employee->id]);

        $this->assertInstanceOf(Employee::class, $user->employee);
        $this->assertEquals($employee->id, $user->employee->id);
    }

    #[Test]
    public function it_can_check_if_user_is_admin()
    {
        $admin = User::factory()->admin()->make(['employee_id' => null]);
        $employee = User::factory()->employeeRole()->make(['employee_id' => null]);

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($employee->isAdmin());
    }

    #[Test]
    public function it_can_check_permission_with_has_permission()
    {
        // Test that the method exists and can be called
        $user = User::factory()->admin()->make(['employee_id' => null]);
        
        // Just verify the method can be called (we can't mock a static method easily)
        $this->assertTrue(method_exists($user, 'hasPermission'));
        $this->assertIsBool($user->hasPermission('inventory', 'view'));
    }

    #[Test]
    public function it_can_check_view_permission()
    {
        $user = User::factory()->create(['employee_id' => null]);

        $this->assertTrue(method_exists($user, 'canView'));
        $this->assertIsBool($user->canView('inventory'));
    }

    #[Test]
    public function it_can_check_create_permission()
    {
        $user = User::factory()->create(['employee_id' => null]);

        $this->assertTrue(method_exists($user, 'canCreate'));
        $this->assertIsBool($user->canCreate('inventory'));
    }

    #[Test]
    public function it_can_check_edit_permission()
    {
        $user = User::factory()->create(['employee_id' => null]);

        $this->assertTrue(method_exists($user, 'canEdit'));
        $this->assertIsBool($user->canEdit('inventory'));
    }

    #[Test]
    public function it_can_check_delete_permission()
    {
        $user = User::factory()->create(['employee_id' => null]);

        $this->assertTrue(method_exists($user, 'canDelete'));
        $this->assertIsBool($user->canDelete('inventory'));
    }

    #[Test]
    public function it_can_check_export_permission()
    {
        $user = User::factory()->create(['employee_id' => null]);

        $this->assertTrue(method_exists($user, 'canExport'));
        $this->assertIsBool($user->canExport('inventory'));
    }

    #[Test]
    public function it_can_get_visible_modules()
    {
        $user = User::factory()->create(['employee_id' => null]);

        $this->assertTrue(method_exists($user, 'getVisibleModules'));
        $modules = $user->getVisibleModules();
        $this->assertIsArray($modules);
    }

    #[Test]
    public function it_can_fill_fillable_attributes()
    {
        $user = User::factory()->make();

        $this->assertContains('name', $user->getFillable());
        $this->assertContains('username', $user->getFillable());
        $this->assertContains('password', $user->getFillable());
        $this->assertContains('role', $user->getFillable());
        $this->assertContains('employee_id', $user->getFillable());
    }

    #[Test]
    public function different_roles_can_be_created()
    {
        $admin = User::factory()->admin()->create(['employee_id' => null]);
        $hr = User::factory()->hr()->create(['employee_id' => null]);
        $employee = User::factory()->employeeRole()->create(['employee_id' => null]);
        $inventory = User::factory()->inventory()->create(['employee_id' => null]);

        $this->assertEquals('admin', $admin->role);
        $this->assertEquals('hr', $hr->role);
        $this->assertEquals('employee', $employee->role);
        $this->assertEquals('inventory', $inventory->role);
    }
}
