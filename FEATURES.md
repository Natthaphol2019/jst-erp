# 📋 เอกสารระบบ JST ERP - คู่มือการใช้งาน

## 🎯 ภาพรวมระบบ

**JST ERP** เป็นระบบบริหารจัดการทรัพยากรองค์กร (Enterprise Resource Planning) ที่พัฒนาด้วย **Laravel 12 (PHP 8.2)** และ **MySQL**

ระบบออกแบบมาเพื่อจัดการกระบวนการทำงานหลัก 4 ด้าน:
1. 👥 **จัดการบุคลากร** (Human Resources)
2. ⏰ **จัดการเวลาทำงาน** (Time Management)
3. 📦 **จัดการคลังสินค้า** (Inventory Management)
4. 📊 **รายงานและวิเคราะห์** (Reports & Analytics)

---

## 🔐 บทบาทผู้ใช้งาน (Roles)

| บทบาท | สัญลักษณ์ | สิทธิ์ |
|--------|-----------|--------|
| **Admin** | ⚙️ | ทั้งหมด - จัดการทุกอย่าง |
| **HR** | 👥 | จัดการพนักงาน, เวลาทำงาน |
| **Manager** | 👔 | ดูรายงาน, อนุมัติ |
| **Inventory** | 📦 | จัดการคลังสินค้า, ยืม-คืน, เบิก |
| **Employee** | 👤 | ดูข้อมูลตัวเอง, ยืม/เบิกของ |

---

## 📊 แผนผังการทำงาน

```
┌─────────────────────────────────────────────────────────────┐
│                      JST ERP System                         │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────────┐  │
│  │   HR Module   │  │  Time Module │  │ Inventory Module │  │
│  │              │  │              │  │                  │  │
│  │ • พนักงาน    │  │ • บันทึกเวลา │  │ • สินค้า         │  │
│  │ • แผนก       │  │ • สรุป       │  │ • หมวดหมู่       │  │
│  │ • ตำแหน่ง    │  │ • ปิดงวด     │  │ • ยืม-คืน        │  │
│  └──────┬───────┘  └──────┬───────┘  │ • เบิก           │  │
│         │                 │          │ • รายงาน         │  │
│         └────────┬────────┘          └────────┬─────────┘  │
│                  │                             │            │
│         ┌────────▼─────────────────────────────▼─────────┐  │
│         │           Notification System                   │  │
│         │  • แจ้งเตือนอนุมัติ  • แจ้งเตือนเกินกำหนด      │  │
│         │  • แจ้งเตือนสต๊อก   • แจ้งเตือนสถานะ            │  │
│         └────────────────────────────────────────────────┘  │
│                                                             │
│         ┌────────────────────────────────────────────────┐  │
│         │         Reports & Dashboards                    │  │
│         │  • Admin Dashboard   • HR Dashboard             │  │
│         │  • Inventory Dash    • Employee Dash            │  │
│         │  • Export Excel      • Print Reports            │  │
│         └────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
```

---

## 1. 🔐 ระบบตรวจสอบสิทธิ์ (Authentication)

### 📍 หน้าที่เกี่ยวข้อง
- `/login` - หน้าเข้าสู่ระบบ
- `/logout` - ออกจากระบบ

### ⚙️ บทบาทและหน้าที่
- ตรวจสอบตัวตนผู้ใช้งาน (Username + Password)
- กำหนดสิทธิ์การเข้าถึงตาม Role
- จัดการ Session (เข้า/ออก ระบบ)
- Redirect ไป Dashboard ตาม Role

### 🔄 กระบวนการทำงาน
```
1. ผู้ใช้กรอก Username + Password
2. ระบบตรวจสอบในฐานข้อมูล (users table)
3. ถ้าถูกต้อง → สร้าง Session
4. Redirect ตาม Role:
   - admin     → /admin/dashboard
   - hr        → /hr/dashboard
   - manager   → /manager/dashboard
   - inventory → /inventory/dashboard
   - employee  → /employee/dashboard
5. ออกจากระบบ → ลบ Session → กลับไปหน้า Login
```

---

## 2. 👥 โมดูลจัดการบุคลากร (HR Module)

### 📍 เมนูที่เกี่ยวข้อง
- 👥 จัดการพนักงาน (`/hr/employees`)
- 🏢 จัดการแผนก (`/hr/departments`)
- 💼 จัดการตำแหน่ง (`/hr/positions`)

### 📄 ไฟล์ที่เกี่ยวข้อง
```
Controllers:
  - app/Http/Controllers/HR/EmployeeController.php
  - app/Http/Controllers/HR/DepartmentController.php
  - app/Http/Controllers/HR/PositionController.php

Models:
  - app/Models/Employee.php
  - app/Models/Department.php
  - app/Models/Position.php
  - app/Models/User.php

Views:
  - resources/views/hr/employees/*.blade.php
  - resources/views/hr/departments/*.blade.php
  - resources/views/hr/positions/*.blade.php
```

### ⚙️ บทบาทและหน้าที่
| ฟีเจอร์ | หน้าที่ | ผู้ใช้ |
|---------|--------|--------|
| จัดการพนักงาน | เพิ่ม/แก้ไข/ลบ พนักงาน + สร้างบัญชีผู้ใช้ + อัปโหลดรูป | Admin, HR |
| จัดการแผนก | จัดการโครงสร้างแผนกในองค์กร | Admin, HR |
| จัดการตำแหน่ง | กำหนดตำแหน่งในแต่ละแผนก | Admin, HR |

### 🔄 กระบวนการทำงาน - จัดการพนักงาน
```
1. Admin/HR เข้าเมนู "จัดการพนักงาน"
2. กด "เพิ่มพนักงานใหม่"
3. กรอกข้อมูล:
   - รหัสพนักงาน (auto-generate: JST-001, JST-002, ...)
   - แผนก (เลือกจาก dropdown)
   - ตำแหน่ง (เลือกตามแผนกที่เลือก)
   - ข้อมูลส่วนตัว (ชื่อ, นามสกุล, เพศ, วันที่เริ่มงาน)
   - บัญชีผู้ใช้ (Username, Password, Role)
   - อัปโหลดรูปโปรไฟล์ (optional)
4. กดบันทึก
5. ระบบสร้าง:
   - Employee record (employees table)
   - User record (users table) เชื่อมโยงผ่าน employee_id
6. พนักงานสามารถ Login ได้ทันที
```

### 🔗 ความสัมพันธ์ของข้อมูล
```
Department (แผนก)
  ├── positions (ตำแหน่งในแผนก)
  └── employees (พนักงานในแผนก)
        └── user (บัญชีผู้ใช้)
```

---

## 3. ⏰ โมดูลจัดการเวลาทำงาน (Time Management)

### 📍 เมนูที่เกี่ยวข้อง
- ⏱️ บันทึกเวลาจากบัตร (`/hr/time-records/batch-select`)
- 📊 รายงานสรุปรายเดือน (`/hr/time-records/summary`)
- 🔒 ปิดงวดเวลาทำงาน (`/hr/time-records/lock`)

### 📄 ไฟล์ที่เกี่ยวข้อง
```
Controllers:
  - app/Http/Controllers/HR/TimeRecordController.php

Models:
  - app/Models/TimeRecord.php
  - app/Models/TimeRecordDetail.php
  - app/Models/TimeRecordLog.php

Views:
  - resources/views/hr/time_records/batch_select.blade.php
  - resources/views/hr/time_records/batch_form.blade.php
  - resources/views/hr/time_records/summary.blade.php
  - resources/views/hr/time_records/lock_period.blade.php
```

### ⚙️ บทบาทและหน้าที่
| ฟีเจอร์ | หน้าที่ | ผู้ใช้ |
|---------|--------|--------|
| บันทึกเวลา | บันทึกเวลาเข้า-ออก งาน แบบรวม (Batch) | Admin, HR |
| รายงานสรุป | ดูสรุปเวลาทำงานรายเดือน รายคน | Admin, HR |
| ปิดงวด | ล็อกงวดเวลา ไม่ให้แก้ไขข้อมูลเก่า | Admin, HR |

### 🔄 กระบวนการทำงาน - บันทึกเวลา (Batch)
```
1. Admin/HR เลือกเมนู "บันทึกเวลาจากบัตร"
2. เลือก:
   - แผนก (หรือทั้งหมด)
   - วันที่ต้องการบันทึก
3. ระบบแสดงฟอร์มตารางเวลาของพนักงานทุกคนในแผนก
4. กรอกข้อมูลเวลาสำหรับแต่ละคน:
   - เวลาเข้างาน
   - เวลาออกงาน
   - เวลา OT (ถ้ามี)
   - แบ่งเป็น 3 ช่วง: เช้า, บ่าย, OT
5. กดบันทึก
6. ระบบสร้าง:
   - TimeRecord (บันทึกหลักของวันนั้น)
   - TimeRecordDetail (รายละเอียดแต่ละช่วง)
   - TimeRecordLog (log การแก้ไข)
```

### 🔄 กระบวนการทำงาน - ปิดงวด
```
1. Admin/HR เลือกเมนู "ปิดงวดเวลาทำงาน"
2. เลือก เดือน/ปี ที่ต้องการปิด
3. ระบบแสดงรายการที่ยังไม่ปิด
4. กดยืนยันปิดงวด
5. ข้อมูลในเดือนนั้นจะไม่สามารถแก้ไขได้อีก
```

---

## 4. 📦 โมดูลจัดการคลังสินค้า (Inventory Module)

### 📍 เมนูที่เกี่ยวข้อง
- 📦 รายการสินค้า/อุปกรณ์ (`/inventory/items`)
- 🏷️ จัดการหมวดหมู่สินค้า (`/inventory/categories`)
- 🛍️ รายการยืมทั้งหมด (`/inventory/borrowing`)
- ➕ สร้างใบยืมใหม่ (`/inventory/borrowing/create`)
- 📋 รายการเบิกทั้งหมด (`/inventory/requisition`)
- ➕ สร้างใบเบิกใหม่ (`/inventory/requisition/create`)
- 📊 ประวัติเคลื่อนไหวสต๊อก (`/inventory/transactions`)
- 📈 สรุปยอดคงเหลือ (`/inventory/transactions/summary`)

### 📄 ไฟล์ที่เกี่ยวข้อง
```
Controllers:
  - app/Http/Controllers/Inventory/DashboardController.php
  - app/Http/Controllers/Inventory/ItemController.php
  - app/Http/Controllers/Inventory/ItemCategoryController.php
  - app/Http/Controllers/Inventory/BorrowingController.php
  - app/Http/Controllers/Inventory/RequisitionController.php
  - app/Http/Controllers/Inventory/StockTransactionController.php
  - app/Http/Controllers/Inventory/BarcodeController.php

Models:
  - app/Models/Item.php
  - app/Models/ItemCategory.php
  - app/Models/Requisition.php
  - app/Models/RequisitionItem.php
  - app/Models/StockTransaction.php

Services:
  - app/Services/StockService.php (จัดการสต๊อกแบบ atomic)

Views:
  - resources/views/inventory/items/*.blade.php
  - resources/views/inventory/categories/*.blade.php
  - resources/views/inventory/borrowing/*.blade.php
  - resources/views/inventory/requisition/*.blade.php
  - resources/views/inventory/transactions/*.blade.php
```

---

### 4.1 📦 จัดการสินค้า/อุปกรณ์

### ⚙️ บทบาทและหน้าที่
| ฟีเจอร์ | หน้าที่ | ผู้ใช้ |
|---------|--------|--------|
| จัดการสินค้า | เพิ่ม/แก้ไข/ลบ สินค้า + อัปโหลดรูป + Barcode | Admin, Inventory |
| จัดการหมวดหมู่ | จัดการหมวดหมู่สินค้า | Admin, Inventory |
| อัปโหลดรูป | อัปโหลดรูปสินค้า (JPG, PNG, GIF max 2MB) | Admin, Inventory |
| Barcode/QR | สร้างบาร์โค้ด + QR Code + พิมพ์ฉลาก | Admin, Inventory |

### 🔄 กระบวนการทำงาน
```
1. เลือกเมนู "รายการสินค้า/อุปกรณ์"
2. กด "เพิ่มสินค้าใหม่"
3. กรอกข้อมูล:
   - รหัสสินค้า (unique)
   - ชื่อสินค้า
   - หมวดหมู่
   - ประเภท: อุปกรณ์ (ยืม-คืนได้) หรือ วัสดุสิ้นเปลือง (ใช้แล้วหมดไป)
   - หน่วยนับ (ชิ้น, อัน, กล่อง, ฯลฯ)
   - จำนวนคงเหลือ (เริ่มต้น)
   - ขั้นต่ำ (Min Stock - จะแจ้งเตือนถ้าน้อยกว่านี้)
   - สถานที่เก็บ
   - สถานะ (พร้อมใช้งาน, ซ่อมบำรุง, ไม่พร้อมใช้)
   - อัปโหลดรูป (optional)
4. บันทึก
5. สามารถพิมพ์ Barcode/QR Code ได้จากหน้าแก้ไข
```

---

### 4.2 🛍️ ระบบยืม-คืนอุปกรณ์

### ⚙️ บทบาทและหน้าที่
| ฟีเจอร์ | หน้าที่ | ผู้ใช้ |
|---------|--------|--------|
| สร้างใบยืม | สร้างรายการยืมอุปกรณ์ + หักสต๊อกทันที | Admin, Inventory |
| แก้ไขใบยืม | แก้ไขข้อมูลใบยืม (ก่อนคืน) | Admin, Inventory |
| คืนสินค้า | คืนอุปกรณ์ (บางส่วนหรือทั้งหมด) | Admin, Inventory |
| ติดตามสถานะ | ดูสถานะการยืม (กำลังยืม, คืนบางส่วน, คืนครบ, เกินกำหนด) | Admin, Inventory |

### 🔄 กระบวนการทำงาน - สร้างใบยืม
```
1. เลือกเมนู "สร้างใบยืมใหม่"
2. กรอกข้อมูล:
   - ผู้ยืม (เลือกพนักงาน)
   - วันที่ยืม
   - กำหนดคืน
   - หมายเหตุ (optional)
3. เพิ่มรายการสินค้าที่ต้องการยืม:
   - เลือกสินค้า (ประเภท: อุปกรณ์ เท่านั้น)
   - ระบุจำนวน
   - ระบบตรวจสอบสต๊อกแบบ real-time (ต้องพอ)
4. กดบันทึก
5. ระบบ:
   - สร้าง Requisition (req_type = 'borrow', status = 'approved')
   - หักสต๊อกทันที (ใช้ StockService.deductStock)
   - บันทึก StockTransaction (transaction_type = 'borrow_out')
   - แจ้งเตือนถ้ามีการยืม
6. สถานะ: "กำลังยืม"
```

### 🔄 กระบวนการทำงาน - คืนสินค้า
```
1. เลือกใบยืมที่ต้องการคืน → กดปุ่ม "คืนสินค้า"
2. ระบบแสดงรายการที่ยืมไว้
3. ระบุจำนวนที่คืน (สามารถคืนบางส่วนได้):
   - คืนทั้งหมด → สถานะเปลี่ยนเป็น "คืนครบแล้ว"
   - คืนบางส่วน → สถานะเปลี่ยนเป็น "คืนบางส่วน"
4. ระบุวันที่คืนจริง + หมายเหตุ (optional)
5. กดบันทึก
6. ระบบ:
   - คืนสต๊อกตามจำนวนที่คืน (ใช้ StockService.addStock)
   - อัปเดต quantity_returned ใน RequisitionItem
   - บันทึก StockTransaction (transaction_type = 'borrow_return')
   - อัปเดตสถานะใบยืม
7. แจ้งเตือนผู้ยืมว่าคืนสำเร็จ
```

### 🔄 สถานะการยืม
| สถานะ | ความหมาย | สี |
|-------|---------|-----|
| `approved` | กำลังยืม | 🟡 เหลือง |
| `returned_partial` | คืนบางส่วน | 🔵 ฟ้า |
| `returned_all` | คืนครบแล้ว | 🟢 เขียว |
| ⚠️ เกินกำหนด | ยืมเกินวันที่กำหนด (แดง) | 🔴 แดง |

---

### 4.3 📋 ระบบเบิกอุปทาน (Consumption)

### ⚙️ บทบาทและหน้าที่
| ฟีเจอร์ | หน้าที่ | ผู้ใช้ |
|---------|--------|--------|
| สร้างใบเบิก | สร้างรายการเบิกวัสดุสิ้นเปลือง (รออนุมัติ) | Admin, Inventory, Employee |
| แก้ไขใบเบิก | แก้ไขใบเบิก (สถานะ pending เท่านั้น) | Admin, Inventory |
| อนุมัติ/ปฏิเสธ | อนุมัติหรือปฏิเสธใบเบิก + หักสต๊อก | Admin, Inventory |
| ติดตามสถานะ | ดูสถานะการเบิก | ทุกคน |

### 🔄 กระบวนการทำงาน - สร้างใบเบิก
```
1. เลือกเมนู "สร้างใบเบิกใหม่"
2. กรอกข้อมูล:
   - ผู้เบิก (เลือกพนักงาน)
   - วันที่เบิก
   - เหตุผลในการเบิก (หมายเหตุ)
3. เพิ่มรายการสินค้าที่ต้องการเบิก:
   - เลือกสินค้า (อุปกรณ์ หรือ วัสดุสิ้นเปลือง)
   - ระบุจำนวน
   - ระบบตรวจสอบสต๊อกเบื้องต้น
4. กดบันทึก
5. ระบบ:
   - สร้าง Requisition (req_type = 'consume', status = 'pending')
   - สร้าง RequisitionItem สำหรับแต่ละรายการ
   - ยังไม่หักสต๊อก (รออนุมัติ)
   - ส่งการแจ้งเตือนถึง Admin/Inventory ว่ามีใบเบิกใหม่
6. สถานะ: "รออนุมัติ"
```

### 🔄 กระบวนการทำงาน - อนุมัติ/ปฏิเสธ
```
1. Admin/Inventory เข้าเมนู "รายการเบิกทั้งหมด"
2. เลือกใบเบิกที่สถานะ "รออนุมัติ"
3. กดปุ่ม "อนุมัติ/ปฏิเสธ"
4. ตรวจสอบรายการและสต๊อก
5. เลือกดำเนินการ:
   ✅ อนุมัติ → หักสต๊อกทันที → สถานะ: "อนุมัติแล้ว"
   ❌ ปฏิเสธ → ไม่หักสต๊อก → สถานะ: "ปฏิเสธ"
6. ระบุหมายเหตุผู้อนุมัติ (optional)
7. ระบบ:
   - ถ้าอนุมัติ:
     • อัปเดต status = 'approved'
     • หักสต๊อกผ่าน StockService.deductStock
     • บันทึก StockTransaction (transaction_type = 'consume_out')
   - ถ้าปฏิเสธ:
     • อัปเดต status = 'rejected'
   - ส่งการแจ้งเตือนถึงผู้เบิก
```

### 🔄 สถานะการเบิก
| สถานะ | ความหมาย | สี |
|-------|---------|-----|
| `pending` | รออนุมัติ | 🟡 เหลือง |
| `approved` | อนุมัติแล้ว (หักสต๊อกแล้ว) | 🟢 เขียว |
| `rejected` | ปฏิเสธ | 🔴 แดง |

---

### 4.4 📊 ระบบรายงานคลังสินค้า

### ⚙️ บทบาทและหน้าที่
| ฟีเจอร์ | หน้าที่ | ผู้ใช้ |
|---------|--------|--------|
| ประวัติเคลื่อนไหว | ดูประวัติสต๊อกเข้า-ออกทุกรายการ | Admin, Inventory |
| สรุปยอดคงเหลือ | ดูยอดคงเหลือปัจจุบัน + แจ้งเตือน | Admin, Inventory |
| รายงานรายวัน | ดูสถิติการเคลื่อนไหวรายวัน | Admin, Inventory |
| รายงานตามหมวดหมู่ | ดูสถิติตามหมวดหมู่สินค้า | Admin, Inventory |
| Export Excel | ส่งออกรายงานเป็นไฟล์ Excel | Admin, Inventory |

### 🔄 ประเภท Stock Transaction
| Transaction Type | ความหมาย | เมื่อไหร่ |
|-----------------|---------|----------|
| `borrow_out` | ยืมออก | สร้างใบยืม |
| `borrow_return` | คืนยืม | คืนสินค้า |
| `consume_out` | เบิกใช้ | อนุมัติใบเบิก |
| `in` | เข้า | ปรับเพิ่มสต๊อก |
| `out` | ออก | ปรับลดสต๊อก |
| `adjust` | ปรับปรุง | ปรับยอดด้วยมือ |
| `return` | คืน | คืนสินค้าทั่วไป |

---

## 5. 👤 โมดูลจัดการตัวเอง (Self-Service)

### 📍 เมนูที่เกี่ยวข้อง
- 👤 แก้ไขข้อมูลส่วนตัว (`/profile/edit`)
- 🔑 เปลี่ยนรหัสผ่าน (`/profile/change-password`)

### 📄 ไฟล์ที่เกี่ยวข้อง
```
Controllers:
  - app/Http/Controllers/ProfileController.php

Views:
  - resources/views/profile/edit.blade.php
  - resources/views/profile/change-password.blade.php
```

### ⚙️ บทบาทและหน้าที่
| ฟีเจอร์ | หน้าที่ | ผู้ใช้ |
|---------|--------|--------|
| แก้ไขข้อมูลส่วนตัว | แก้ไขข้อมูลส่วนตัว (ชื่อ, เบอร์โทร, ที่อยู่, อีเมล) | ทุกคน |
| เปลี่ยนรหัสผ่าน | เปลี่ยนรหัสผ่านตัวเอง | ทุกคน |

### 🔄 กระบวนการทำงาน
```
แก้ไขข้อมูลส่วนตัว:
1. เข้าเมนู "แก้ไขข้อมูลส่วนตัว"
2. แก้ไขข้อมูล:
   - คำนำหน้า, ชื่อ, นามสกุล
   - เพศ
   - อีเมล, เบอร์โทรศัพท์
   - ที่อยู่
   - ข้อมูลการทำงาน (ดูได้อย่างเดียว)
3. บันทึก

เปลี่ยนรหัสผ่าน:
1. เข้าเมนู "เปลี่ยนรหัสผ่าน"
2. กรอก:
   - รหัสผ่านปัจจุบัน (ตรวจสอบความถูกต้อง)
   - รหัสผ่านใหม่ (ขั้นต่ำ 6 ตัว)
   - ยืนยันรหัสผ่านใหม่ (ต้องตรงกัน)
3. ระบบตรวจสอบ:
   - รหัสผ่านปัจจุบันต้องถูกต้อง
   - รหัสผ่านใหม่ต้องไม่ซ้ำกับรหัสผ่านเก่า
4. อัปเดตรหัสผ่าน (hash ใหม่)
```

---

## 6. 🔔 ระบบแจ้งเตือน (Notification System)

### 📍 เมนูที่เกี่ยวข้อง
- 🔔 Bell icon (มุมขวาบนของ topbar)
- 📋 การแจ้งเตือนทั้งหมด (`/notifications`)

### 📄 ไฟล์ที่เกี่ยวข้อง
```
Notifications:
  - app/Notifications/RequisitionSubmitted.php
  - app/Notifications/RequisitionApproved.php
  - app/Notifications/RequisitionRejected.php
  - app/Notifications/BorrowingOverdue.php
  - app/Notifications/LowStockAlert.php

Controllers:
  - app/Http/Controllers/NotificationController.php

Views:
  - resources/views/notifications/index.blade.php
```

### ⚙️ บทบาทและหน้าที่
| ประเภท | เมื่อไหร่ | ผู้รับ |
|--------|---------|--------|
| 📋 RequisitionSubmitted | สร้างใบเบิกใหม่ | Admin, Inventory users |
| ✅ RequisitionApproved | ใบเบิกได้รับการอนุมัติ | ผู้เบิก |
| ❌ RequisitionRejected | ใบเบิกถูกปฏิเสธ | ผู้เบิก |
| ⏰ BorrowingOverdue | ยืมอุปกรณ์เกินกำหนด | ผู้ยืม, Admin |
| ⚠️ LowStockAlert | สินค้าต่ำกว่า min_stock | Admin, Inventory users |

### 🔄 กระบวนการทำงาน
```
1. มีเหตุการณ์触发 (เช่น สร้างใบเบิก, อนุมัติ, ปฏิเสธ)
2. Controller สร้าง Notification object
3. ระบบบันทึกลง notifications table
4. Bell icon แสดงจำนวนที่ยังไม่ได้อ่าน
5. ผู้ใช้กดดูรายการ:
   - กดรายการเดียว → อ่านแล้ว → Redirect ไปหน้าที่เกี่ยวข้อง
   - กด "อ่านทั้งหมด" → เปลี่ยนทุกอย่างเป็นอ่านแล้ว
6. Notification ที่อ่านแล้วจะแสดงเป็นสีจาง
```

---

## 7. 📊 Dashboards

### 📍 เมนูที่เกี่ยวข้อง
- 📊 แดชบอร์ด (ตาม Role)

### 📄 ไฟล์ที่เกี่ยวข้อง
```
Controllers:
  - app/Http/Controllers/Admin/DashboardController.php
  - app/Http/Controllers/HR/DashboardController.php
  - app/Http/Controllers/Manager/DashboardController.php
  - app/Http/Controllers/Inventory/DashboardController.php
  - app/Http/Controllers/Employee/DashboardController.php

Views:
  - resources/views/admin/dashboard.blade.php
  - resources/views/hr/dashboard.blade.php
  - resources/views/manager/dashboard.blade.php
  - resources/views/inventory/dashboard.blade.php
  - resources/views/employee/dashboard.blade.php
```

### ⚙️ บทบาทและหน้าที่
| Dashboard | แสดงข้อมูล | ผู้ใช้ |
|-----------|-----------|--------|
| **Admin** | ภาพรวมระบบ, ใบเบิก pendding, สินค้าหมดสต๊อก, พนักงานมาวันนี้ | Admin |
| **HR** | พนักงาน, แผนก, เวลาทำงาน, สถิติมางาน | HR |
| **Manager** | สถิติแผนก, รออนุมัติ, กิจกรรมล่าสุด | Manager |
| **Inventory** | สินค้า, สต๊อก, ใบเบิก, ยืม-คืน | Inventory |
| **Employee** | ใบยืมของฉัน, ใบเบิกของฉัน, มางาน | ทุกคน |

---

## 8. 📥 Import/Export ระบบ

### 📍 เมนูที่เกี่ยวข้อง
- 📥 นำเข้าข้อมูล (`/admin/imports/employees`, `/admin/imports/items`)
- 📤 Export Excel (ปุ่ม Export ในหน้า list ต่างๆ)

### 📄 ไฟล์ที่เกี่ยวข้อง
```
Controllers:
  - app/Http/Controllers/ImportController.php
  - app/Http/Controllers/ExportController.php

Views:
  - resources/views/imports/employees.blade.php
  - resources/views/imports/items.blade.php
```

### ⚙️ บทบาทและหน้าที่
| ฟีเจอร์ | หน้าที่ | ผู้ใช้ |
|---------|--------|--------|
| Import Employees | นำเข้าพนักงานจาก CSV/Excel | Admin |
| Import Items | นำเข้าสินค้าจาก CSV/Excel | Admin, Inventory |
| Export Employees | ส่งออกข้อมูลพนักงานเป็น Excel | Admin, HR |
| Export Items | ส่งออกข้อมูลสินค้าเป็น Excel | Admin, Inventory |
| Export Borrowings | ส่งออกข้อมูลการยืมเป็น Excel | Admin, Inventory |
| Export Requisitions | ส่งออกข้อมูลการเบิกเป็น Excel | Admin, Inventory |
| Export Stock | ส่งออกประวัติสต๊อกเป็น Excel | Admin, Inventory |
| Export Time | ส่งออกข้อมูลเวลาเป็น Excel | Admin, HR |

---

## 9. 🛡️ ระบบความปลอดภัยและความน่าเชื่อถือ

### 📄 ไฟล์ที่เกี่ยวข้อง
```
Trait:
  - app/Traits/ActivityLogTrait.php

Models (with SoftDeletes):
  - app/Models/Employee.php (already had)
  - app/Models/Item.php
  - app/Models/ItemCategory.php
  - app/Models/Requisition.php
  - app/Models/RequisitionItem.php
  - app/Models/Department.php
  - app/Models/Position.php

Service:
  - app/Services/StockService.php (atomic stock operations)

Controllers:
  - app/Http/Controllers/Admin/BackupController.php
  - app/Http/Controllers/Admin/HealthCheckController.php
  - app/Http/Controllers/Admin/ActivityLogController.php

Views:
  - resources/views/admin/activity_logs/*.blade.php
  - resources/views/admin/backups/index.blade.php
  - resources/views/admin/health/index.blade.php
```

### ⚙️ บทบาทและหน้าที่
| ฟีเจอร์ | หน้าที่ | ผู้ใช้ |
|---------|--------|--------|
| Audit Log | บันทึกทุกการเปลี่ยนแปลงข้อมูล | Admin |
| Soft Deletes | ป้องกันข้อมูลลบถาวร | Admin, HR, Inventory |
| Stock Concurrency | ป้องกันสต๊อกติดลบจาก concurrent access | ระบบ |
| Backup/Restore | สำรองและกู้คืนฐานข้อมูล | Admin |
| Health Check | ตรวจสอบสถานะระบบ | Admin |

### 🔄 กระบวนการทำงาน - Audit Log
```
1. มีแก้ไขข้อมูล (create/update/delete) ใน models ที่ใช้ ActivityLogTrait
2. Trait ดักจับ event (created, updated, deleted)
3. บันทึก:
   - ผู้ใช้ (user_id)
   - ประเภท (hr, inventory, system)
   - รายละเอียด (สร้าง, แก้ไข, ลบ)
   - ค่าก่อน/หลัง (สำหรับ update)
4. Admin เข้าดูได้ที่ "บันทึกกิจกรรม"
```

### 🔄 กระบวนการทำงาน - Backup
```
1. Admin เข้าเมนู "สำรองข้อมูล"
2. กด "สร้าง Backup"
3. ระบบ:
   - Dump ฐานข้อมูล MySQL
   - บีบอัดเป็น .sql.gz
   - เก็บใน storage/app/backups/
4. สามารถดาวน์โหลด/ลบ/restore ได้
```

---

## 10. 🔍 ระบบค้นหา (Global Search)

### 📍 เมนูที่เกี่ยวข้อง
- 🔍 ช่องค้นหาใน topbar (ทุกหน้า)

### 📄 ไฟล์ที่เกี่ยวข้อง
```
Controllers:
  - app/Http/Controllers/SearchController.php
```

### ⚙️ บทบาทและหน้าที่
- ค้นหาได้ทั้งระบบ: พนักงาน, สินค้า, ใบเบิก, แผนก, ตำแหน่ง
- AJAX real-time (debounce 300ms)
- Shortcut: `Ctrl+K` หรือ `/` เพื่อโฟกัส
- แสดงผลแยกตามประเภท

### 🔄 กระบวนการทำงาน
```
1. ผู้ใช้พิมพ์คำค้นหา
2. ระบบค้นหาแบบ AJAX (หลังพิมพ์ 300ms)
3. ค้นหาจาก:
   - Employees (ชื่อ, รหัส)
   - Items (ชื่อ, รหัส)
   - Requisitions (เลขที่, หมายเหตุ)
   - Departments (ชื่อ)
   - Positions (ชื่อ)
4. แสดงผลลัพธ์ (สูงสุด 10 รายการต่อประเภท)
5. กดที่ผลลัพธ์ → Redirect ไปหน้ารายละเอียด
```

---

## 📦 Barcode & QR Code

### 📍 เมนูที่เกี่ยวข้อง
- 🖨️ พิมพ์บาร์โค้ด (`/items/{item}/print-barcode`)

### 📄 ไฟล์ที่เกี่ยวข้อง
```
Controllers:
  - app/Http/Controllers/Inventory/BarcodeController.php

Views:
  - resources/views/inventory/items/print-barcode.blade.php
```

### ⚙️ บทบาทและหน้าที่
| ฟีเจอร์ | หน้าที่ | ผู้ใช้ |
|---------|--------|--------|
| Barcode | สร้างบาร์โค้ด Code 128 จาก item_code | Admin, Inventory |
| QR Code | สร้าง QR Code ลิงก์ไปหน้าแก้ไขสินค้า | Admin, Inventory |
| Print Labels | พิมพ์ฉลาก 3 ขนาด (40x25, 50x30, 60x40 มม.) | Admin, Inventory |

---

## 🗄️ โครงสร้างฐานข้อมูล (Database Schema)

### ตารางหลัก
| ตาราง | หน้าที่ | Fields สำคัญ |
|-------|--------|-------------|
| `users` | บัญชีผู้ใช้ | id, username, password, role, employee_id |
| `employees` | ข้อมูลพนักงาน | id, department_id, position_id, employee_code, firstname, lastname, profile_image |
| `departments` | แผนก | id, name, description, next_department_id |
| `positions` | ตำแหน่ง | id, department_id, name, job_description |
| `items` | สินค้า | id, category_id, item_code, name, type, current_stock, min_stock |
| `item_categories` | หมวดหมู่สินค้า | id, name, description |
| `requisitions` | ใบยืม/เบิก | id, employee_id, req_type, status, req_date, due_date, approved_by |
| `requisition_items` | รายการในใบเบิก | id, requisition_id, item_id, quantity_requested, quantity_returned |
| `stock_transactions` | ประวัติเคลื่อนไหวสต๊อก | id, item_id, transaction_type, quantity, balance, requisition_id |
| `time_records` | บันทึกเวลา | id, employee_id, record_date |
| `time_record_details` | รายละเอียดเวลา | id, time_record_id, period (morning/afternoon/ot), time_in, time_out |
| `time_record_logs` | Log การแก้ไขเวลา | id, time_record_id, action, note |
| `notifications` | การแจ้งเตือน | id, notifiable_type, notifiable_id, type, data, read_at |
| `activity_logs` | บันทึกกิจกรรม | id, user_id, log_name, description, subject_type, subject_id, properties |

---

## 🚀 คำสั่งที่สำคัญ

```bash
# เริ่มระบบ (development)
composer run dev

# สร้างฐานข้อมูล
php artisan migrate

# ล้าง cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Cache สำหรับ production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# ดู routes ทั้งหมด
php artisan route:list

# ดู migrations
php artisan migrate:status

# สร้าง backup
php artisan backup:run  (ถ้ามี schedule)

# ดูข้อมูลระบบ
php artisan about
```

---

## 🔑 บัญชีสำหรับทดสอบ

| บทบาท | Username | Password |
|-------|----------|----------|
| Admin | admin | 123456 |

---

## 📊 สรุปภาพรวมระบบ

| ส่วน | จำนวน |
|------|-------|
| Controllers | 28 |
| Views (Blade) | 55 |
| Routes | 113 |
| Migrations | 21 |
| Models | 13 |
| Notifications | 5 |
| Services | 2 |
| Traits | 1 |

---

**เอกสารนี้จัดทำขึ้นเมื่อ:** 2026-04-05
**เวอร์ชันระบบ:** 1.0.0
**เทคโนโลยี:** Laravel 12.56.0, PHP 8.2.12, MySQL
