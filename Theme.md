# JST ERP — Design Pattern Guide

> เอกสารนี้กำหนดมาตรฐาน UI สำหรับทุกหน้าในระบบ JST ERP  
> ทุก component ใหม่ **ต้องอ้างอิงจาก guide นี้** เพื่อให้ภาพรวมสอดคล้องกัน

---

## 1. Two-Tone Theme System (Light ↔ Dark)

ระบบใช้ **CSS custom properties** บน `<html data-theme="...">` เพื่อสลับธีมแบบ smooth  
**Default คือ Light Mode** — Dark Mode เปิดด้วยปุ่มใน topbar และค่าจะถูกจำด้วย `localStorage`

### 1.1 ตาราง Design Tokens

| Token | Light (`data-theme="light"`) | Dark (`data-theme="dark"`) | ใช้กับ |
|---|---|---|---|
| `--bg-base` | `#f0f2f7` | `#0f1117` | body background |
| `--bg-surface` | `#ffffff` | `#12151f` | card, sidebar, topbar |
| `--bg-raised` | `#f7f8fc` | `#1a1e2e` | dropdown, modal |
| `--border` | `rgba(0,0,0,0.07)` | `rgba(255,255,255,0.06)` | เส้นแบ่งทั้งหมด |
| `--text-primary` | `#1a1d2e` | `#e2e8f0` | หัวเรื่อง, ค่าสำคัญ |
| `--text-secondary` | `rgba(0,0,0,0.5)` | `rgba(255,255,255,0.5)` | label, คำอธิบาย |
| `--text-muted` | `rgba(0,0,0,0.28)` | `rgba(255,255,255,0.25)` | placeholder, timestamp |
| `--accent` | `#6366f1` | `#6366f1` | primary action (คงเดิม) |
| `--accent-light` | `#818cf8` | `#818cf8` | link, icon active |
| `--sidebar-bg` | `#ffffff` | `#12151f` | sidebar background |
| `--sidebar-border` | `rgba(0,0,0,0.07)` | `rgba(255,255,255,0.06)` | sidebar border |
| `--topbar-bg` | `#ffffff` | `#12151f` | topbar background |
| `--input-bg` | `rgba(0,0,0,0.04)` | `rgba(255,255,255,0.05)` | input, select |
| `--input-border` | `rgba(0,0,0,0.12)` | `rgba(255,255,255,0.1)` | input border |
| `--table-th-bg` | `rgba(0,0,0,0.02)` | `rgba(255,255,255,0.02)` | table header bg |
| `--table-td-bd` | `rgba(0,0,0,0.05)` | `rgba(255,255,255,0.04)` | table row border |
| `--dropdown-bg` | `#ffffff` | `#1a1e2e` | dropdown menu |
| `--modal-bg` | `#f7f8fc` | `#1a1e2e` | modal content |
| `--sb-hover-bg` | `rgba(99,102,241,0.06)` | `rgba(255,255,255,0.05)` | sidebar link hover |
| `--sb-active-bg` | `rgba(99,102,241,0.12)` | `rgba(99,102,241,0.15)` | sidebar active state |
| `--sb-section-color` | `rgba(0,0,0,0.3)` | `rgba(255,255,255,0.22)` | sidebar section label |
| `--sb-link-color` | `rgba(0,0,0,0.5)` | `rgba(255,255,255,0.5)` | sidebar link default |

### 1.2 วิธีประกาศ Token (ใน `app.blade.php`)

```css
/* Light — Default */
:root,
[data-theme="light"] {
    --bg-base:    #f0f2f7;
    --bg-surface: #ffffff;
    --bg-raised:  #f7f8fc;
    --border:     rgba(0, 0, 0, 0.07);
    --text-primary:   #1a1d2e;
    --text-secondary: rgba(0, 0, 0, 0.5);
    --text-muted:     rgba(0, 0, 0, 0.28);
    --accent:       #6366f1;
    --accent-light: #818cf8;
    /* ... (ดูครบใน app.blade.php) */
}

/* Dark */
[data-theme="dark"] {
    --bg-base:    #0f1117;
    --bg-surface: #12151f;
    --bg-raised:  #1a1e2e;
    --border:     rgba(255, 255, 255, 0.06);
    --text-primary:   #e2e8f0;
    --text-secondary: rgba(255,255,255,0.5);
    --text-muted:     rgba(255,255,255,0.25);
    /* ... */
}
```

### 1.3 Smooth Transition

เพิ่มใน global style เพื่อให้สลับธีมแบบ animation:

```css
*, *::before, *::after {
    transition: background-color 0.22s ease,
                border-color 0.22s ease,
                color 0.18s ease;
}
```

### 1.4 Theme Toggle — JavaScript Pattern

ประกาศใน `app.blade.php` ก่อน `</body>`:

```html
<!-- ป้องกัน flash: ใส่ใน <head> ก่อน paint -->
<script>
    (function () {
        var saved = localStorage.getItem('erpTheme') || 'light';
        document.documentElement.setAttribute('data-theme', saved);
    })();
</script>
```

```javascript
// Global toggle function — เรียกจากปุ่มใดก็ได้
window.toggleTheme = function () {
    var html = document.documentElement;
    var current = html.getAttribute('data-theme') || 'light';
    var next = current === 'light' ? 'dark' : 'light';
    html.setAttribute('data-theme', next);
    localStorage.setItem('erpTheme', next);

    // อัปเดตไอคอนปุ่มทุกตัวในหน้า
    document.querySelectorAll('[data-theme-toggle]').forEach(function (btn) {
        var icon = btn.querySelector('i');
        if (!icon) return;
        icon.className = next === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
        btn.title = next === 'dark' ? 'สลับ Light Mode' : 'สลับ Dark Mode';
    });
};
```

### 1.5 Theme Toggle Button (HTML)

ใส่ attribute `data-theme-toggle` เพื่อให้ JS อัปเดตไอคอนอัตโนมัติ:

```html
<button class="theme-toggle-btn" data-theme-toggle onclick="toggleTheme()" title="สลับ Dark Mode">
    <i class="fas fa-moon"></i>  {{-- Light mode default: แสดง moon --}}
</button>
```

**CSS Class `.theme-toggle-btn`** (อยู่ใน `app.blade.php`):

```css
.theme-toggle-btn {
    display: flex; align-items: center; justify-content: center;
    width: 36px; height: 36px;
    border-radius: 10px;
    background: var(--input-bg);
    border: 1px solid var(--input-border);
    color: var(--text-secondary);
    cursor: pointer;
    transition: all 0.15s;
    font-size: 15px;
}
.theme-toggle-btn:hover {
    background: rgba(99,102,241,0.12);
    border-color: rgba(99,102,241,0.3);
    color: var(--accent-light);
}
```

> **Logic ไอคอน:**  
> Light mode → แสดง 🌙 (moon) → กดแล้วไป Dark  
> Dark mode → แสดง ☀️ (sun) → กดแล้วกลับ Light

---

## 2. Color Palette (Semantic Colors)

Accent และ Status colors คงเดิมทั้งสองธีม — ออกแบบให้ใช้ได้ทั้ง light/dark background

### สีประจำหมวด (ใช้ได้ทั้ง Light & Dark)

| ความหมาย | bg (opacity 12%) | text / icon |
|---|---|---|
| Primary / HR | `rgba(99,102,241,0.12)` | `#818cf8` |
| Success / สต๊อกดี | `rgba(52,211,153,0.12)` | `#34d399` |
| Warning / รออนุมัติ | `rgba(251,191,36,0.12)` | `#fbbf24` |
| Danger / เกินกำหนด | `rgba(239,68,68,0.12)` | `#f87171` |
| Info / ยืม | `rgba(56,189,248,0.12)` | `#38bdf8` |
| Purple / ตำแหน่ง | `rgba(167,139,250,0.12)` | `#a78bfa` |
| Teal / ผู้ใช้ | `rgba(45,212,191,0.12)` | `#2dd4bf` |

> สีเหล่านี้ใช้ rgba opacity ต่ำ จึงทำงานได้ทั้งพื้นขาวและพื้นดำโดยไม่ต้องแยก

---

## 3. Typography

**Font stack:**
```css
font-family: 'IBM Plex Sans', 'Noto Sans Thai', sans-serif;
```

| Role | size | weight | token |
|---|---|---|---|
| Page title | 18px | 600 | `var(--text-primary)` |
| Page subtitle | 13px | 400 | `var(--text-muted)` |
| Card title | 13px | 500 | `var(--text-secondary)` |
| Body / table row | 13–14px | 400 | `var(--text-secondary)` |
| Table header | 11px | 600 | `var(--text-muted)` + uppercase |
| Label | 10–12px | 500–600 | `var(--text-muted)` |
| Timestamp / hint | 11–12px | 400 | `var(--text-muted)` |

> **กฎ:** ห้าม hardcode สีข้อความ (`#e2e8f0`, `rgba(255,255,255,...)`) ในหน้า content  
> ให้ใช้ `var(--text-*)` เสมอ เพื่อให้ธีมทำงานถูกต้อง

---

## 4. Icons

ใช้ **Font Awesome 6 Free** ใน content, **Bootstrap Icons** ใน topbar

> ห้ามใช้ `bi-*` ในหน้า content — ใช้ `fas fa-*` เท่านั้น

### Icon ประจำแต่ละส่วน

| หมวด | icon class |
|---|---|
| Dashboard | `fas fa-tachometer-alt` |
| พนักงาน | `fas fa-users` |
| แผนก | `fas fa-sitemap` |
| ตำแหน่ง | `fas fa-briefcase` |
| บันทึกเวลา | `fas fa-clock` |
| รายงาน | `fas fa-chart-line` |
| สินค้า/คลัง | `fas fa-box-open` |
| หมวดหมู่ | `fas fa-tags` |
| ยืม | `fas fa-hand-holding` |
| เบิก | `fas fa-file-alt` |
| แจ้งเตือน | `fas fa-bell` |
| Admin log | `fas fa-clipboard-check` |
| นำเข้าข้อมูล | `fas fa-file-import` |
| สำรองข้อมูล | `fas fa-database` |
| ตรวจสอบระบบ | `fas fa-heartbeat` |
| ปิดงวด | `fas fa-lock` |
| ออกจากระบบ | `fas fa-sign-out-alt` |
| แก้ไขโปรไฟล์ | `fas fa-user-edit` |
| เปลี่ยนรหัสผ่าน | `fas fa-key` |
| สถานะ OK | `fas fa-check` |
| สถานะ error | `fas fa-times` |
| สถานะ warning | `fas fa-exclamation-triangle` |
| ลูกศร/link | `fas fa-arrow-right` |
| ไม่มีข้อมูล | `fas fa-inbox` |
| สลับธีม (moon) | `fas fa-moon` |
| สลับธีม (sun) | `fas fa-sun` |

---

## 5. Component Classes

CSS classes ทั้งหมดอยู่ใน `app.blade.php` และใช้ `var(--*)` ทุกจุด

---

### 5.1 Page Header

```html
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-{icon} me-2" style="color: #818cf8;"></i>{ชื่อหน้า}
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">
            {คำอธิบายสั้น ๆ}
        </p>
    </div>
    <a href="..." class="erp-btn-primary">
        <i class="fas fa-plus me-2"></i>สร้างใหม่
    </a>
</div>
```

---

### 5.2 Stat Card (`.erp-stat-card`)

```html
<div class="erp-stat-card">
    <div class="erp-stat-icon" style="background: rgba(99,102,241,0.12); color: #818cf8;">
        <i class="fas fa-users"></i>
    </div>
    <div class="erp-stat-body">
        <div class="erp-stat-label">พนักงานทั้งหมด</div>
        <div class="erp-stat-value">{{ number_format($total) }}</div>
    </div>
    <a href="..." class="erp-stat-link" style="color: #818cf8;">
        ดูรายละเอียด <i class="fas fa-arrow-right"></i>
    </a>
</div>
```

---

### 5.3 Card (`.erp-card`)

```html
<div class="erp-card">
    <div class="erp-card-header">
        <span class="erp-card-title">
            <i class="fas fa-list-ul me-2" style="color: #818cf8;"></i>ชื่อ section
        </span>
        <a href="..." class="erp-card-action">ดูทั้งหมด <i class="fas fa-arrow-right ms-1"></i></a>
    </div>
    <div class="erp-card-body">
        {{-- content --}}
    </div>
</div>
```

---

### 5.4 Table (`.erp-table`)

```html
<div class="erp-table-wrap">
    <table class="erp-table">
        <thead>
            <tr>
                <th>คอลัมน์</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="color: var(--text-secondary);">ข้อมูล</td>
            </tr>
        </tbody>
    </table>
</div>
```

---

### 5.5 Badge (`.erp-badge`)

```html
{{-- สีตาม status --}}
<span class="erp-badge" style="background: rgba(52,211,153,0.12); color: #34d399;">
    <i class="fas fa-check me-1"></i>อนุมัติ
</span>
<span class="erp-badge" style="background: rgba(251,191,36,0.12); color: #fbbf24;">
    <i class="fas fa-clock me-1"></i>รออนุมัติ
</span>
<span class="erp-badge" style="background: rgba(239,68,68,0.12); color: #f87171;">
    <i class="fas fa-times me-1"></i>ปฏิเสธ
</span>
```

---

### 5.6 Buttons

```html
<a href="..." class="erp-btn-primary"><i class="fas fa-plus me-2"></i>สร้างใหม่</a>
<a href="..." class="erp-btn-secondary"><i class="fas fa-times me-2"></i>ยกเลิก</a>
<button class="erp-btn-danger"><i class="fas fa-trash me-2"></i>ลบ</button>
```

---

### 5.7 Form

```html
<div class="mb-3">
    <label class="erp-label">ชื่อพนักงาน</label>
    <input type="text" class="erp-input" placeholder="กรอกชื่อ...">
</div>
<div class="mb-3">
    <label class="erp-label">แผนก</label>
    <select class="erp-select">
        <option>-- เลือกแผนก --</option>
    </select>
</div>
<div class="mb-3">
    <label class="erp-label">หมายเหตุ</label>
    <textarea class="erp-textarea" placeholder="กรอกหมายเหตุ..."></textarea>
</div>
<div class="d-flex gap-2 mt-4">
    <button class="erp-btn-primary"><i class="fas fa-save me-2"></i>บันทึก</button>
    <a href="..." class="erp-btn-secondary"><i class="fas fa-times me-2"></i>ยกเลิก</a>
</div>
```

---

### 5.8 Alert

```html
<div class="erp-alert erp-alert-success">
    <i class="fas fa-check-circle me-2"></i>บันทึกข้อมูลสำเร็จ
</div>
<div class="erp-alert erp-alert-danger">
    <i class="fas fa-exclamation-circle me-2"></i>เกิดข้อผิดพลาด
</div>
<div class="erp-alert erp-alert-warning">
    <i class="fas fa-exclamation-triangle me-2"></i>สต๊อกใกล้หมด
</div>
<div class="erp-alert erp-alert-info">
    <i class="fas fa-info-circle me-2"></i>ข้อมูลอ้างอิง
</div>
```

---

### 5.9 Empty State

```html
<div class="erp-empty">
    <i class="fas fa-inbox"></i>
    <div>ยังไม่มีข้อมูล</div>
    <a href="..." class="erp-btn-primary mt-3">
        <i class="fas fa-plus me-2"></i>เพิ่มรายการแรก
    </a>
</div>
```

---

## 6. Layout Pattern ต่อหน้า

```blade
@extends('layouts.app')

@section('title', 'ชื่อหน้า - JST ERP')

@section('content')

{{-- 1. Page Header --}}
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            <i class="fas fa-{icon} me-2" style="color: #818cf8;"></i>{ชื่อหน้า}
        </h4>
        <p style="font-size: 13px; color: var(--text-muted); margin: 0;">{คำอธิบาย}</p>
    </div>
</div>

{{-- 2. Flash message --}}
@if(session('success'))
    <div class="erp-alert erp-alert-success mb-4">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    </div>
@endif

{{-- 3. Content --}}
<div class="row g-3">
    ...
</div>

@endsection
```

---

## 7. กฎการเขียนสีใน Blade

| ❌ ห้ามทำ | ✅ ให้ทำแทน |
|---|---|
| `color: #e2e8f0` | `color: var(--text-primary)` |
| `color: rgba(255,255,255,0.5)` | `color: var(--text-secondary)` |
| `background: #12151f` | `background: var(--bg-surface)` |
| `border-color: rgba(255,255,255,0.06)` | `border-color: var(--border)` |
| `background: rgba(255,255,255,0.05)` (input) | `background: var(--input-bg)` |

> **ข้อยกเว้น:** สี badge/status (`rgba(52,211,153,0.12)`, `#34d399` ฯลฯ) ใช้ hardcode ได้เพราะออกแบบให้ neutral ในทั้ง 2 ธีม

---

## 8. Checklist ก่อน Push โค้ด

- [ ] ใช้ `erp-*` classes แทน Bootstrap defaults ทั้งหมด
- [ ] ไม่มี hardcode สีข้อความ — ใช้ `var(--text-*)` เสมอ
- [ ] ไม่มี hardcode สีพื้นหลัง — ใช้ `var(--bg-*)` หรือ `var(--input-bg)`
- [ ] ไม่มี `text-dark`, `text-muted`, `bg-white` (Bootstrap classes)
- [ ] Icon ทุกตัวใช้ `fas fa-*` (Font Awesome 6)
- [ ] Badge สถานะใช้ `.erp-badge` พร้อม color pair ตาม section 2
- [ ] หน้าที่มี form ใช้ `.erp-input`, `.erp-select`, `.erp-label`
- [ ] Page header ครบ: icon + ชื่อ + subtitle
- [ ] Flash message ใช้ `.erp-alert erp-alert-{type}`
- [ ] Empty state ใช้ `.erp-empty`
- [ ] ทดสอบทั้ง Light และ Dark mode ก่อน push