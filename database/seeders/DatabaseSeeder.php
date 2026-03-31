<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Position;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. สร้างแผนกทั้งหมดก่อน
        $deptSales = Department::create(['name' => 'ฝ่ายขาย (Sales)']);
        $deptEng = Department::create(['name' => 'วิศวกรรม (Engineering)']);
        $deptProd = Department::create(['name' => 'ฝ่ายผลิต (Production)']);
        $deptQC = Department::create(['name' => 'ควบคุมคุณภาพ (QC/QA)']);
        $deptSite = Department::create(['name' => 'ติดตั้ง (Site)']);
        $deptProcure = Department::create(['name' => 'จัดซื้อ (Procurement)']);
        $deptWH = Department::create(['name' => 'คลังสินค้า (Warehouse)']);
        $deptAdmin = Department::create(['name' => 'บริหาร (Admin/HR/บัญชี)']);

        // 2. อัปเดต Workflow (เชื่อมแผนกตามที่คุณซีออกแบบไว้)
        $deptSales->update(['next_department_id' => $deptEng->id]);
        $deptEng->update(['next_department_id' => $deptProd->id]);
        $deptProd->update(['next_department_id' => $deptQC->id]);
        $deptQC->update(['next_department_id' => $deptSite->id]);
        $deptProcure->update(['next_department_id' => $deptProd->id]);
        $deptWH->update(['next_department_id' => $deptProd->id]);

        // 3. สร้างตำแหน่ง (Positions) ผูกเข้ากับแผนก พร้อมระบุหน้าที่หลัก
        $positions = [
            // ฝ่ายขาย
            ['department_id' => $deptSales->id, 'name' => 'Sales Engineer', 'job_description' => 'รับลูกค้า, เสนอราคา, เก็บ requirement'],
            ['department_id' => $deptSales->id, 'name' => 'Sales', 'job_description' => 'รับลูกค้า, เสนอราคา, เก็บ requirement'],

            // วิศวกรรม
            ['department_id' => $deptEng->id, 'name' => 'Design Engineer', 'job_description' => 'ออกแบบ, เขียนแบบ'],
            ['department_id' => $deptEng->id, 'name' => 'Draftman', 'job_description' => 'ออกแบบ, เขียนแบบ'],

            // ฝ่ายผลิต
            ['department_id' => $deptProd->id, 'name' => 'Production Manager', 'job_description' => 'คุมทีมผลิตงาน, เชื่อม, ประกอบ'],
            ['department_id' => $deptProd->id, 'name' => 'ช่างผลิต/ช่างเชื่อม', 'job_description' => 'ผลิตงาน, เชื่อม, ประกอบ'],

            // QC/QA
            ['department_id' => $deptQC->id, 'name' => 'QC Inspector', 'job_description' => 'ตรวจคุณภาพงาน'],

            // ติดตั้งหน้างาน
            ['department_id' => $deptSite->id, 'name' => 'Site Engineer', 'job_description' => 'คุมงานติดตั้งหน้างานลูกค้า'],
            ['department_id' => $deptSite->id, 'name' => 'ช่างติดตั้ง', 'job_description' => 'ติดตั้งหน้างานลูกค้า'],

            // จัดซื้อ
            ['department_id' => $deptProcure->id, 'name' => 'Purchasing', 'job_description' => 'จัดซื้อวัสดุ อุปกรณ์'],

            // คลังสินค้า
            ['department_id' => $deptWH->id, 'name' => 'Store / Stock', 'job_description' => 'ควบคุมการเบิกจ่ายวัสดุ Production'],

            // บริหาร (Admin/HR/บัญชี)
            ['department_id' => $deptAdmin->id, 'name' => 'Admin', 'job_description' => 'จัดการเอกสารทั่วไป ทุกแผนก'],
            ['department_id' => $deptAdmin->id, 'name' => 'HR', 'job_description' => 'จัดการบุคคล, เงินเดือน'],
            ['department_id' => $deptAdmin->id, 'name' => 'Accountant', 'job_description' => 'จัดการบัญชี, การเงิน'],
        ];

        foreach ($positions as $pos) {
            Position::create($pos);
        }
        $adminPosition = Position::where('name', 'Admin')->first();

        // สร้างพนักงานผู้ดูแลระบบ
        $adminEmp = \App\Models\Employee::create([
            'department_id' => $deptAdmin->id,
            'position_id' => $adminPosition->id,
            'employee_code' => 'ADMIN-001',
            'prefix' => 'นาย',
            'firstname' => 'ผู้ดูแล',
            'lastname' => 'ระบบ',
            'status' => 'active',
            'start_date' => now(),
        ]);

        // สร้างบัญชีให้ผู้ดูแลระบบไว้สำหรับล็อกอิน
        \App\Models\User::create([
            'name' => 'ผู้ดูแลระบบ JST',
            'username' => 'admin',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'employee_id' => $adminEmp->id
        ]);
    }

}