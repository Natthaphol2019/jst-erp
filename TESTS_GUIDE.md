# วิธีรัน PHPUnit Tests สำหรับ JST ERP

## คำสั่งพื้นฐาน

### รันเทสทั้งหมด:
```bash
php artisan test
```

### รันเฉพาะไฟล์:
```bash
php artisan test tests/Unit/UserTest.php
```

### รันเทสที่ชื่อเฉพาะ:
```bash
php artisan test --filter=it_can_create_a_user
```

## เทสที่สร้างให้แล้ว

### Unit Tests (47 tests)
เทสสำหรับ Models:

1. **UserTest** (14 tests)
   - สร้าง user
   - ตรวจสอบ password hiding
   - ตรวจสอบ employee relationship
   - ตรวจสอบ roles และ permissions

2. **ItemTest** (16 tests)
   - สร้างสินค้า
   - ตรวจสอบ category relationship
   - ตรวจสอบ stock transactions
   - ป้องกัน stock ติดลบ
   - ตรวจสอบ type ต่างๆ

3. **EmployeeTest** (14 tests)
   - สร้างพนักงาน
   - ตรวจสอบ department และ position relationships
   - ตรวจสอบ time records
   - Soft deletes

### Feature Tests (52 tests)
เทสสำหรับ HTTP endpoints:

1. **AuthTest** (13 tests)
   - Login/Logout
   - ตรวจสอบ redirect ตาม role

2. **ItemCrudTest** (21 tests)
   - CRUD operations สำหรับสินค้า
   - อัปโหลดรูปภาพ
   - Filtering และ searching

3. **EmployeeCrudTest** (18 tests)
   - CRUD operations สำหรับพนักงาน
   - อัปโหลดรูปโปรไฟล์
   - Filtering และ searching

## สิ่งที่ต้องแก้ไขถ้าเทสไม่ผ่าน

### 1. Database Schema ไม่ตรงกัน
ถ้าเทสเสียด้วย error "Column not found":
- เปิดไฟล์ใน `database/factories/`
- แก้ไข column names ให้ตรงกับ database จริง

### 2. Routes ไม่ตรงกัน
ถ้าเทสเสียด้วย error "Route not found":
- ตรวจสอบ `routes/web.php`
- แก้ไข route names ใน Feature tests

### 3. Validation rules ไม่ตรงกัน
ถ้าเทสเสียด้วย error "Validation failed":
- ตรวจสอบ validation rules ใน Controllers
- แก้ไขข้อมูลในเทสให้ถูกต้อง

## วิธีเขียนเทสเพิ่ม

### ตัวอย่าง: Unit Test สำหรับ Model
```php
#[Test]
public function it_can_create_a_department()
{
    $department = Department::factory()->create([
        'name' => 'IT Department',
    ]);

    $this->assertDatabaseHas('departments', [
        'name' => 'IT Department',
    ]);
}
```

### ตัวอย่าง: Feature Test สำหรับ Controller
```php
#[Test]
public function it_can_view_departments_index()
{
    $user = User::factory()->admin()->create();
    
    $response = $this->actingAs($user)
        ->get(route('admin.departments.index'));

    $response->assertStatus(200);
    $response->assertViewIs('admin.departments.index');
}
```

## Factories ที่ใช้งาน

สร้างไฟล์ factories ใน `database/factories/`:
- `UserFactory` ✅
- `EmployeeFactory` ✅
- `DepartmentFactory` ✅
- `PositionFactory` ✅
- `ItemFactory` ✅
- `ItemCategoryFactory` ✅
- `StockTransactionFactory` ✅
- `TimeRecordFactory` ✅

## หมายเหตุสำคัญ

1. **Base TestCase**: ทุกเทสใช้ `Tests\TestCase` เป็น base class
2. **RefreshDatabase**: ใช้ trait นี้เพื่อให้ได้ database สะอาดทุกครั้ง
3. **Factories**: ใช้ factories สร้างข้อมูลแทนการ hardcode
4. **SQLite in-memory**: เทสใช้ SQLite แทน MySQL เพื่อความเร็ว

## ถ้าเทสไม่ผ่านทั้งหมด

ตรวจสอบ:
1. มีไฟล์ `database/database.sqlite` หรือไม่ (สร้างไฟล์ว่างๆ ก็ได้)
2. `.env` มีการตั้งค่าที่ถูกต้องหรือไม่
3. Migrations ถูกต้องหรือไม่

สร้างไฟล์ database.sqlite:
```bash
type nul > database/database.sqlite
```

## การรันเทส

### เทสทั้งหมด:
```bash
php artisan test
```

### เทสเฉพาะ Unit:
```bash
php artisan test tests/Unit
```

### เทสเฉพาะ Feature:
```bash
php artisan test tests/Feature
```

### เทสพร้อมดูรายละเอียด:
```bash
php artisan test --verbose
```
