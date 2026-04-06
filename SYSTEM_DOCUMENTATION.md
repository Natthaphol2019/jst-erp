# JST ERP System Documentation

## 📋 Table of Contents
1. [System Overview](#system-overview)
2. [User Roles](#user-roles)
3. [Authentication](#authentication)
4. [API Endpoints](#api-endpoints)
5. [Features by Module](#features-by-module)
6. [Database Schema](#database-schema)
7. [Usage Guide](#usage-guide)

---

## System Overview

**JST ERP** is a comprehensive Enterprise Resource Planning system built with Laravel 12. It manages human resources, inventory, borrowing/returning equipment, and requisition processes.

### Technology Stack
- **Backend**: Laravel 12.56.0
- **PHP**: 8.2.12
- **Database**: MySQL
- **Frontend**: Bootstrap, Blade Templates
- **Export**: PhpSpreadsheet (Excel)
- **Barcode**: Milon Barcode

### Base URL
```
http://127.0.0.1:8000
```

---

## User Roles

| Role | Description | Access Level |
|------|-------------|--------------|
| **admin** | System Administrator | Full access to all modules |
| **hr** | Human Resources Staff | HR management, time records |
| **manager** | Manager/Executive | View reports and dashboards only |
| **inventory** | Inventory Staff | Full inventory management |
| **employee** | General Employee | Create borrowings/requisitions, view own data |

### Role Access Matrix

| Module | admin | hr | manager | inventory | employee |
|--------|:-----:|:--:|:-------:|:---------:|:--------:|
| Admin Dashboard | ✅ | ❌ | ❌ | ❌ | ❌ |
| HR Management | ✅ | ✅ | ❌ | ❌ | ❌ |
| Time Records | ✅ | ✅ | ❌ | ❌ | ❌ |
| Inventory Management | ✅ | ❌ | ❌ | ✅ | ❌ |
| Borrowing/Return | ✅ | ❌ | ❌ | ✅ | ✅ (own) |
| Requisition | ✅ | ❌ | ❌ | ✅ | ✅ (own) |
| Reports | ✅ | ✅ | ✅ (view) | ✅ | ❌ |
| Imports/Exports | ✅ | ❌ | ❌ | ❌ | ❌ |
| Backups | ✅ | ❌ | ❌ | ❌ | ❌ |
| Activity Logs | ✅ | ❌ | ❌ | ❌ | ❌ |

---

## Authentication

### Login
```
POST /login
Content-Type: application/x-www-form-urlencoded

username: your_username
password: your_password
```

### Logout
```
POST /logout
```

### Default Credentials
| Username | Password | Role |
|----------|----------|------|
| admin | password | admin |

> ⚠️ Change default password immediately after first login!

---

## API Endpoints

### 1. Public Routes (No Authentication)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/` | Redirect to login |
| GET | `/login` | Show login form |
| POST | `/login` | Authenticate user |

### 2. Authenticated Routes (Any Role)

#### Profile
| Method | Endpoint | Route Name | Description |
|--------|----------|------------|-------------|
| GET | `/profile/edit` | `profile.edit` | Edit profile |
| PUT | `/profile/update` | `profile.update` | Update profile |
| GET | `/profile/change-password` | `profile.change-password` | Change password form |
| PUT | `/profile/update-password` | `profile.update-password` | Update password |

#### Notifications
| Method | Endpoint | Route Name | Description |
|--------|----------|------------|-------------|
| GET | `/notifications` | `notifications.index` | List notifications |
| POST | `/notifications/{id}/read` | `notifications.read` | Mark as read |
| POST | `/notifications/read-all` | `notifications.read-all` | Mark all as read |
| GET | `/notifications/unread-count` | `notifications.unread-count` | Get unread count (JSON) |

#### Export (Excel)
| Method | Endpoint | Route Name | Description |
|--------|----------|------------|-------------|
| GET | `/exports/employees` | `exports.employees` | Export employees |
| GET | `/exports/items` | `exports.items` | Export items |
| GET | `/exports/borrowings` | `exports.borrowings` | Export borrowings |
| GET | `/exports/requisitions` | `exports.requisitions` | Export requisitions |
| GET | `/exports/stock-transactions` | `exports.stock-transactions` | Export stock (with date filter) |
| GET | `/exports/time-records` | `exports.time-records` | Export time records (by month) |

#### Barcode
| Method | Endpoint | Route Name | Description |
|--------|----------|------------|-------------|
| GET | `/items/{id}/barcode` | `inventory.items.barcode` | Generate barcode |
| GET | `/items/{id}/qrcode` | `inventory.items.qrcode` | Generate QR code |
| GET | `/items/{id}/print-barcode` | `inventory.items.print-barcode` | Print barcode |

#### Image Uploads
| Method | Endpoint | Route Name | Description |
|--------|----------|------------|-------------|
| POST | `/uploads/employees/{id}/image` | `uploads.employee` | Upload employee photo |
| DELETE | `/uploads/employees/{id}/image` | `uploads.employee.delete` | Delete employee photo |
| POST | `/uploads/items/{id}/image` | `uploads.item` | Upload item photo |
| DELETE | `/uploads/items/{id}/image` | `uploads.item.delete` | Delete item photo |

### 3. Admin Routes (Role: admin)

#### Dashboard & System
| Method | Endpoint | Route Name | Description |
|--------|----------|------------|-------------|
| GET | `/admin/dashboard` | `admin.dashboard` | Admin dashboard |
| GET | `/admin/activity-logs` | `admin.activity-logs.index` | View activity logs |
| GET | `/admin/activity-logs/{id}` | `admin.activity-logs.show` | Activity log detail |
| GET | `/admin/health` | `admin.health` | System health check |

#### Import
| Method | Endpoint | Route Name | Description |
|--------|----------|------------|-------------|
| GET | `/admin/imports/employees` | `admin.imports.employees.form` | Import employees form |
| POST | `/admin/imports/employees` | `admin.imports.employees.process` | Process employee import |
| GET | `/admin/imports/items` | `admin.imports.items.form` | Import items form |
| POST | `/admin/imports/items` | `admin.imports.items.process` | Process item import |
| GET | `/admin/imports/template/employees` | `admin.imports.template.employees` | Download employee template |
| GET | `/admin/imports/template/items` | `admin.imports.template.items` | Download item template |

#### Backup
| Method | Endpoint | Route Name | Description |
|--------|----------|------------|-------------|
| GET | `/admin/backups` | `admin.backups.index` | List backups |
| POST | `/admin/backups` | `admin.backups.create` | Create backup |
| GET | `/admin/backups/{filename}/download` | `admin.backups.download` | Download backup |
| DELETE | `/admin/backups/{filename}` | `admin.backups.delete` | Delete backup |
| POST | `/admin/backups/{filename}/restore` | `admin.backups.restore` | Restore from backup |

### 4. Manager Routes (Role: manager)

| Method | Endpoint | Route Name | Description |
|--------|----------|------------|-------------|
| GET | `/manager/dashboard` | `manager.dashboard` | Manager dashboard |

### 5. Employee Routes (Role: employee)

| Method | Endpoint | Route Name | Description |
|--------|----------|------------|-------------|
| GET | `/employee/dashboard` | `employee.dashboard` | Employee dashboard |
| GET | `/employee/borrowings` | `employee.borrowings` | My borrowings |
| GET | `/employee/borrowings/create` | `employee.borrowing.create` | Create borrowing |
| POST | `/employee/borrowings` | `employee.borrowing.store` | Store borrowing |
| GET | `/employee/borrowings/{id}` | `employee.borrowing.show` | View borrowing |
| GET | `/employee/requisitions` | `employee.requisitions` | My requisitions |
| GET | `/employee/requisitions/create` | `employee.requisition.create` | Create requisition |
| POST | `/employee/requisitions` | `employee.requisition.store` | Store requisition |
| GET | `/employee/requisitions/{id}` | `employee.requisition.show` | View requisition |

### 6. HR Routes (Roles: admin, hr)

#### Dashboard
| Method | Endpoint | Route Name | Description |
|--------|----------|------------|-------------|
| GET | `/hr/dashboard` | `hr.dashboard` | HR dashboard |

#### Employees
| Method | Endpoint | Route Name | Description |
|--------|----------|------------|-------------|
| GET | `/hr/employees` | `hr.employees.index` | List employees |
| GET | `/hr/employees/create` | `hr.employees.create` | Create employee form |
| POST | `/hr/employees` | `hr.employees.store` | Store employee |
| GET | `/hr/employees/{id}` | `hr.employees.show` | Employee detail |
| GET | `/hr/employees/{id}/edit` | `hr.employees.edit` | Edit employee |
| PUT | `/hr/employees/{id}` | `hr.employees.update` | Update employee |
| DELETE | `/hr/employees/{id}` | `hr.employees.destroy` | Delete employee |
| PATCH | `/hr/employees/{id}/toggle-block` | `hr.employees.toggle-block` | Toggle active/inactive |

#### Departments
| Method | Endpoint | Route Name | Description |
|--------|----------|------------|-------------|
| GET | `/hr/departments` | `hr.departments.index` | List departments |
| GET | `/hr/departments/create` | `hr.departments.create` | Create department |
| POST | `/hr/departments` | `hr.departments.store` | Store department |
| GET | `/hr/departments/{id}` | `hr.departments.show` | Department detail |
| GET | `/hr/departments/{id}/edit` | `hr.departments.edit` | Edit department |
| PUT | `/hr/departments/{id}` | `hr.departments.update` | Update department |
| DELETE | `/hr/departments/{id}` | `hr.departments.destroy` | Delete department |

#### Positions
| Method | Endpoint | Route Name | Description |
|--------|----------|------------|-------------|
| GET | `/hr/positions` | `hr.positions.index` | List positions |
| GET | `/hr/positions/create` | `hr.positions.create` | Create position |
| POST | `/hr/positions` | `hr.positions.store` | Store position |
| GET | `/hr/positions/{id}` | `hr.positions.show` | Position detail |
| GET | `/hr/positions/{id}/edit` | `hr.positions.edit` | Edit position |
| PUT | `/hr/positions/{id}` | `hr.positions.update` | Update position |
| DELETE | `/hr/positions/{id}` | `hr.positions.destroy` | Delete position |

#### Time Records
| Method | Endpoint | Route Name | Description |
|--------|----------|------------|-------------|
| GET | `/hr/time-records/batch-select` | `hr.time-records.batch.select` | Batch time entry select |
| GET | `/hr/time-records/batch-form` | `hr.time-records.batch.form` | Batch time entry form |
| POST | `/hr/time-records/batch-store` | `hr.time-records.batch.store` | Store batch time records |
| GET | `/hr/time-records/summary` | `hr.time-records.summary` | Monthly time summary |
| GET | `/hr/time-records/lock` | `hr.time-records.lock` | Lock period |
| POST | `/hr/time-records/lock` | `hr.time-records.lock.store` | Store lock period |
| GET | `/hr/time-records/logs` | `hr.time-records.logs` | Time audit logs |

### 7. Inventory Routes (Roles: admin, inventory)

#### Dashboard
| Method | Endpoint | Route Name | Description |
|--------|----------|------------|-------------|
| GET | `/inventory/dashboard` | `inventory.dashboard` | Inventory dashboard |

#### Items
| Method | Endpoint | Route Name | Description |
|--------|----------|------------|-------------|
| GET | `/inventory/items` | `inventory.items.index` | List items |
| GET | `/inventory/items/create` | `inventory.items.create` | Create item form |
| POST | `/inventory/items` | `inventory.items.store` | Store item |
| GET | `/inventory/items/{id}` | `inventory.items.show` | Item detail |
| GET | `/inventory/items/{id}/edit` | `inventory.items.edit` | Edit item |
| PUT | `/inventory/items/{id}` | `inventory.items.update` | Update item |
| DELETE | `/inventory/items/{id}` | `inventory.items.destroy` | Delete item |
| PATCH | `/inventory/items/{id}/toggle-status` | `inventory.items.toggle-status` | Toggle available/unavailable |

#### Categories
| Method | Endpoint | Route Name | Description |
|--------|----------|------------|-------------|
| GET | `/inventory/categories` | `inventory.categories.index` | List categories |
| GET | `/inventory/categories/create` | `inventory.categories.create` | Create category |
| POST | `/inventory/categories` | `inventory.categories.store` | Store category |
| GET | `/inventory/categories/{id}` | `inventory.categories.show` | Category detail |
| GET | `/inventory/categories/{id}/edit` | `inventory.categories.edit` | Edit category |
| PUT | `/inventory/categories/{id}` | `inventory.categories.update` | Update category |
| DELETE | `/inventory/categories/{id}` | `inventory.categories.destroy` | Delete category |

#### Borrowing
| Method | Endpoint | Route Name | Description |
|--------|----------|------------|-------------|
| GET | `/inventory/borrowing` | `inventory.borrowing.index` | List borrowings |
| GET | `/inventory/borrowing/create` | `inventory.borrowing.create` | Create borrowing |
| POST | `/inventory/borrowing` | `inventory.borrowing.store` | Store borrowing |
| GET | `/inventory/borrowing/{id}` | `inventory.borrowing.show` | Borrowing detail |
| GET | `/inventory/borrowing/{id}/edit` | `inventory.borrowing.edit` | Edit borrowing |
| PUT | `/inventory/borrowing/{id}` | `inventory.borrowing.update` | Update borrowing |
| GET | `/inventory/borrowing/{id}/return` | `inventory.borrowing.return` | Return form |
| POST | `/inventory/borrowing/{id}/return` | `inventory.borrowing.return.store` | Process return |

#### Requisition (Admin/Inventory View)
| Method | Endpoint | Route Name | Description |
|--------|----------|------------|-------------|
| GET | `/inventory/requisition` | `inventory.requisition.index` | List requisitions |
| GET | `/inventory/requisition/{id}/approve` | `inventory.requisition.approve` | Approval form |
| POST | `/inventory/requisition/{id}/approve` | `inventory.requisition.approve.store` | Approve/reject |

#### Stock Reports
| Method | Endpoint | Route Name | Description |
|--------|----------|------------|-------------|
| GET | `/inventory/transactions` | `inventory.transactions.index` | Stock transactions |
| GET | `/inventory/transactions/{id}` | `inventory.transactions.show` | Transaction detail |
| GET | `/inventory/transactions/summary` | `inventory.transactions.summary` | Stock summary |
| GET | `/inventory/transactions/daily-report` | `inventory.transactions.daily` | Daily report |
| GET | `/inventory/transactions/category-report` | `inventory.transactions.category` | Category report |

---

## Features by Module

### 1. Human Resources (HR)
- Employee lifecycle management (CRUD)
- Department and position management
- Auto-generate employee codes (JST-NNN)
- Auto-create user accounts with employees
- Block/soft-delete employees
- Photo upload for employees
- Protect admin users from modification

### 2. Time Management
- Batch time entry for multiple employees
- 3 periods: Morning, Afternoon, Overtime
- Attendance statuses: Present, Late, Leave, Absent
- Lock/unlock time periods to prevent changes
- Monthly summary reports with export to Excel
- Audit trail for all time changes

### 3. Inventory Management
- Item management with categories
- Stock tracking (current vs minimum)
- Low stock alerts
- Image upload for items
- Barcode/QR code generation
- Available/Unavailable/Maintenance statuses
- Stock transaction history

### 4. Borrowing System
- Create borrowing requests
- Auto-approve employee borrowings
- Track return dates and overdue items
- Partial/full returns
- Stock deduction on borrow, restoration on return
- Overdue notifications

### 5. Requisition System
- Employee consumable requests
- Auto-deduct stock on approval
- Approval workflow
- Reject option with notes
- Notifications to admin/inventory staff

### 6. Import/Export
- **Import**: CSV/Excel templates for employees and items
- **Export**: All major modules to Excel (employees, items, borrowings, requisitions, stock, time records)
- Template downloads for standardized imports

### 7. Backup & Restore
- Create database backups
- Download backup files
- Restore from backups
- Delete old backups

### 8. Activity Logs
- Track all system changes
- Filterable by user, module, action
- Detailed change logs

### 9. Health Check
- Database connection and size
- Disk space usage
- PHP version and extensions
- Laravel version and environment
- Cache status
- Storage permissions
- Session configuration
- Recent errors

---

## Database Schema

### Core Tables
- `users` - System users (linked to employees)
- `employees` - Employee records
- `departments` - Department master
- `positions` - Position master
- `time_records` - Time attendance records
- `time_record_details` - Time entry details (morning, afternoon, OT)
- `time_lock_periods` - Locked time periods
- `time_record_audit_logs` - Time change audit trail

### Inventory Tables
- `items` - Item master
- `item_categories` - Item categories
- `stock_transactions` - Stock movement history
- `requisitions` - Borrowing/requisition headers
- `requisition_items` - Line items per requisition

### System Tables
- `notifications` - User notifications
- `activity_logs` - System activity logs
- `permissions` - Permission definitions
- `role_permissions` - Role-permission mappings

---

## Usage Guide

### Getting Started

#### 1. Installation
```bash
cd c:\xampp\htdocs\jst_erp
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install && npm run build
php artisan serve
```

#### 2. First Login
- URL: `http://127.0.0.1:8000`
- Use admin credentials
- Change default password immediately

### Common Workflows

#### Add New Employee
1. Go to **HR → จัดการพนักงาน**
2. Click **เพิ่มพนักงาน**
3. Fill form (code auto-generated: JST-NNN)
4. Set username and password (default: password123)
5. Assign role (hr, inventory, employee)
6. Upload photo (optional)
7. Save

#### Record Time Attendance
1. Go to **HR → บันทึกเวลาจากบัตร**
2. Select department and date range
3. Choose employee
4. Fill morning/afternoon/OT times
5. Set status (Present/Late/Leave/Absent)
6. Save

#### Lock Time Period
1. Go to **HR → ปิดงวดเวลาทำงาน**
2. Select month and period (first/second half)
3. Click **ล็อกงวด**
4. Locked records cannot be modified

#### Add New Item
1. Go to **Inventory → รายการสินค้า/อุปกรณ์**
2. Click **เพิ่มสินค้า**
3. Fill details (code auto-generated)
4. Set category, type, stock levels
5. Upload image (optional)
6. Save

#### Create Borrowing
1. Go to **Inventory → สร้างใบยืมใหม่**
2. Select employee
3. Add items (returnable/equipment types only)
4. Set borrow and return dates
5. Save (auto-approved)
6. Stock deducted automatically

#### Return Items
1. Go to **Inventory → รายการยืมทั้งหมด**
2. Click on borrowing
3. Click **คืนของ**
4. Enter return quantities
5. Add notes (optional)
6. Stock restored automatically

#### Approve Requisition
1. Go to **Inventory → รายการเบิกทั้งหมด**
2. Click on pending requisition
3. Review items
4. Click **อนุมัติ** or **ปฏิเสธ**
5. Add approval note
6. Stock deducted on approval

#### Import Data
1. Go to **Admin → นำเข้าข้อมูล**
2. Download template (employees or items)
3. Fill data in Excel/CSV
4. Upload file (max 5MB)
5. Review results
6. Errors shown for failed rows

#### Export Data
1. Go to any list view
2. Click **Export Excel** button
3. File downloads automatically
4. Or use **/exports/** endpoints directly

#### Create Backup
1. Go to **Admin → สำรองข้อมูล**
2. Click **สร้าง Backup**
3. Wait for completion
4. Download if needed

---

## Quick Reference

### Keyboard Shortcuts
| Shortcut | Action |
|----------|--------|
| `Ctrl+K` | Global search |
| `/` | Focus search |
| `Esc` | Close search |

### Status Codes
- **Employee**: active, inactive, resigned
- **Item**: available, unavailable, maintenance
- **Requisition**: pending, approved, rejected, issued, returned_all, returned_partial
- **Time**: present, late, leave, absent

### Item Types
- **equipment**: Can be borrowed and returned
- **consumable**: Can be requisitioned (consumed)

---

## Support

For issues or questions, contact the system administrator.

**Last Updated**: April 6, 2026
**Version**: 1.0.0
