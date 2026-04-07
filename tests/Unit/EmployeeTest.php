<?php

namespace Tests\Unit;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\TimeRecord;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_create_an_employee()
    {
        $department = Department::factory()->create();
        $position = Position::factory()->create();

        $employee = Employee::factory()->create([
            'department_id' => $department->id,
            'position_id' => $position->id,
            'firstname' => 'John',
            'lastname' => 'Doe',
            'employee_code' => 'EMP001',
        ]);

        $this->assertDatabaseHas('employees', [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'employee_code' => 'EMP001',
        ]);
    }

    #[Test]
    public function it_belongs_to_a_department()
    {
        $department = Department::factory()->create();
        $employee = Employee::factory()->create(['department_id' => $department->id]);

        $this->assertInstanceOf(Department::class, $employee->department);
        $this->assertEquals($department->id, $employee->department->id);
    }

    #[Test]
    public function it_belongs_to_a_position()
    {
        $position = Position::factory()->create();
        $employee = Employee::factory()->create(['position_id' => $position->id]);

        $this->assertInstanceOf(Position::class, $employee->position);
        $this->assertEquals($position->id, $employee->position->id);
    }

    #[Test]
    public function it_can_have_a_user_relationship()
    {
        $employee = Employee::factory()->create();
        $user = User::factory()->create(['employee_id' => $employee->id]);

        $this->assertInstanceOf(User::class, $employee->user);
        $this->assertEquals($user->id, $employee->user->id);
    }

    #[Test]
    public function it_has_many_time_records()
    {
        $employee = Employee::factory()->create();
        
        TimeRecord::factory()->count(3)->create(['employee_id' => $employee->id]);

        $this->assertCount(3, $employee->timeRecords);
        $this->assertInstanceOf(TimeRecord::class, $employee->timeRecords->first());
    }

    #[Test]
    public function it_can_fill_fillable_attributes()
    {
        $employee = Employee::factory()->make();

        $fillable = $employee->getFillable();
        $this->assertContains('department_id', $fillable);
        $this->assertContains('position_id', $fillable);
        $this->assertContains('employee_code', $fillable);
        $this->assertContains('prefix', $fillable);
        $this->assertContains('firstname', $fillable);
        $this->assertContains('lastname', $fillable);
        $this->assertContains('gender', $fillable);
        $this->assertContains('start_date', $fillable);
        $this->assertContains('status', $fillable);
        $this->assertContains('profile_image', $fillable);
        $this->assertContains('phone', $fillable);
        $this->assertContains('address', $fillable);
    }

    #[Test]
    public function it_uses_soft_deletes()
    {
        $employee = Employee::factory()->create();
        $employeeId = $employee->id;

        $employee->delete();

        $this->assertSoftDeleted('employees', ['id' => $employeeId]);
        $this->assertNull(Employee::find($employeeId));
        $this->assertNotNull(Employee::withTrashed()->find($employeeId));
    }

    #[Test]
    public function it_can_be_created_with_different_statuses()
    {
        $active = Employee::factory()->active()->create();
        $inactive = Employee::factory()->inactive()->create();

        $this->assertEquals('active', $active->status);
        $this->assertEquals('inactive', $inactive->status);
    }

    #[Test]
    public function it_generates_unique_employee_code()
    {
        $employee1 = Employee::factory()->create();
        $employee2 = Employee::factory()->create();

        $this->assertNotEquals($employee1->employee_code, $employee2->employee_code);
    }

    #[Test]
    public function it_can_have_various_gender_values()
    {
        $male = Employee::factory()->create(['gender' => 'male']);
        $female = Employee::factory()->create(['gender' => 'female']);
        $other = Employee::factory()->create(['gender' => 'other']);

        $this->assertEquals('male', $male->gender);
        $this->assertEquals('female', $female->gender);
        $this->assertEquals('other', $other->gender);
    }

    #[Test]
    public function it_can_store_start_date()
    {
        $startDate = now()->subYear();
        $employee = Employee::factory()->create(['start_date' => $startDate]);

        $this->assertNotNull($employee->start_date);
    }

    #[Test]
    public function it_can_store_contact_information()
    {
        $employee = Employee::factory()->create([
            'phone' => '0812345678',
            'address' => '123 Test Street',
        ]);

        $this->assertEquals('0812345678', $employee->phone);
        $this->assertEquals('123 Test Street', $employee->address);
    }

    #[Test]
    public function it_can_store_profile_image()
    {
        $employee = Employee::factory()->create([
            'profile_image' => 'employees/test_image.jpg',
        ]);

        $this->assertEquals('employees/test_image.jpg', $employee->profile_image);
    }

    #[Test]
    public function it_can_have_various_prefixes()
    {
        $mr = Employee::factory()->create(['prefix' => 'Mr.']);
        $mrs = Employee::factory()->create(['prefix' => 'Mrs.']);
        $ms = Employee::factory()->create(['prefix' => 'Ms.']);

        $this->assertEquals('Mr.', $mr->prefix);
        $this->assertEquals('Mrs.', $mrs->prefix);
        $this->assertEquals('Ms.', $ms->prefix);
    }
}
