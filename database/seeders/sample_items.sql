-- ============================================================
-- ลบข้อมูลเก่าในตารางสินค้าและหมวดหมู่
-- ============================================================
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE `items`;
TRUNCATE TABLE `item_categories`;
SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- INSERT หมวดหมู่สินค้า (ภาษาไทย)
-- ============================================================
INSERT INTO `item_categories` (`id`, `name`, `prefix`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'วัตถุดิบ', 'RM', 'วัตถุดิบหลักที่ใช้สำหรับกระบวนการผลิต', NOW(), NOW(), NULL),
(2, 'สารเคมี', 'CHM', 'สารเคมีที่ใช้ในโรงงานและในกระบวนการผลิต', NOW(), NOW(), NULL),
(3, 'อะไหล่เครื่องจักร', 'MSP', 'อะไหล่เครื่องจักรและอุปกรณ์', NOW(), NOW(), NULL),
(4, 'อุปกรณ์ความปลอดภัย', 'SAF', 'อุปกรณ์ป้องกันความปลอดภัย', NOW(), NOW(), NULL),
(5, 'เครื่องมือช่าง', 'TLS', 'เครื่องมือช่างและอุปกรณ์มือ', NOW(), NOW(), NULL),
(6, 'บรรจุภัณฑ์', 'PKG', 'วัสดุบรรจุภัณฑ์', NOW(), NOW(), NULL),
(7, 'อุปกรณ์ไฟฟ้า', 'ELC', 'อุปกรณ์ไฟฟ้าและอิเล็กทรอนิกส์', NOW(), NOW(), NULL),
(8, 'น้ำมันหล่อลื่น', 'LUB', 'น้ำมันหล่อลื่นและสารหล่อลื่น', NOW(), NOW(), NULL),
(9, 'อุปกรณ์สำนักงาน', 'OFF', 'อุปกรณ์สำนักงานและเครื่องเขียน', NOW(), NOW(), NULL),
(10, 'อุปกรณ์ทำความสะอาด', 'CLN', 'อุปกรณ์และน้ำยาทำความสะอาด', NOW(), NOW(), NULL);

-- ============================================================
-- INSERT สินค้า
-- ============================================================
INSERT INTO `items` (`category_id`, `item_code`, `asset_number`, `name`, `type`, `unit`, `current_stock`, `min_stock`, `location`, `image_url`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES

-- วัตถุดิบ
(1, 'RM-001', NULL, 'เหล็กแผ่น SS400 6mm', 'consumable', 'แผ่น', 50, 10, 'คลังวัตถุดิบ A', NULL, 'available', NOW(), NOW(), NULL),
(1, 'RM-002', NULL, 'เหล็กกล่อง 50x50x2.3mm', 'consumable', 'เส้น', 120, 20, 'คลังวัตถุดิบ A', NULL, 'available', NOW(), NOW(), NULL),
(1, 'RM-003', NULL, 'เหล็กฉาก 40x40x3mm', 'consumable', 'เส้น', 80, 15, 'คลังวัตถุดิบ B', NULL, 'available', NOW(), NOW(), NULL),
(1, 'RM-004', NULL, 'สแตนเลสแผ่น 304 3mm', 'consumable', 'แผ่น', 30, 5, 'คลังวัตถุดิบ A', NULL, 'available', NOW(), NOW(), NULL),
(1, 'RM-005', NULL, 'อลูมิเนียมแผ่น 1.5mm', 'consumable', 'แผ่น', 40, 10, 'คลังวัตถุดิบ B', NULL, 'available', NOW(), NOW(), NULL),

-- สารเคมี
(2, 'CHM-001', NULL, 'น้ำยาเชื่อมเหล็ก', 'consumable', 'ลิตร', 25, 5, 'ห้องสารเคมี', NULL, 'available', NOW(), NOW(), NULL),
(2, 'CHM-002', NULL, 'Isopropyl Alcohol 99%', 'consumable', 'ลิตร', 120, 50, 'ห้องสารเคมี', NULL, 'available', NOW(), NOW(), NULL),
(2, 'CHM-003', NULL, 'น้ำยาล้างคราบไขมัน', 'consumable', 'ลิตร', 40, 10, 'ห้องสารเคมี', NULL, 'available', NOW(), NOW(), NULL),
(2, 'CHM-004', NULL, 'สีพ่นอุตสาหกรรม สีเทา', 'consumable', 'กระป๋อง', 60, 15, 'ห้องสารเคมี', NULL, 'available', NOW(), NOW(), NULL),

-- อะไหล่เครื่องจักร
(3, 'MSP-001', NULL, 'สายพานมอเตอร์ 3HP', 'consumable', 'เส้น', 8, 2, 'ห้องอะไหล่', NULL, 'available', NOW(), NOW(), NULL),
(3, 'MSP-002', NULL, 'ตลับลูกปืน 6205', 'consumable', 'ลูก', 15, 5, 'ห้องอะไหล่', NULL, 'available', NOW(), NOW(), NULL),
(3, 'MSP-003', NULL, 'ใบมีดตัดเหล็ก', 'consumable', 'แผ่น', 20, 5, 'ห้องอะไหล่', NULL, 'available', NOW(), NOW(), NULL),
(3, 'MSP-004', NULL, 'หัวเชื่อม MIG', 'consumable', 'อัน', 30, 10, 'ห้องอะไหล่', NULL, 'available', NOW(), NOW(), NULL),

-- อุปกรณ์ความปลอดภัย
(4, 'SAF-001', NULL, 'หมวกนิรภัย', 'equipment', 'ใบ', 25, 10, 'ห้องเซฟตี้', NULL, 'available', NOW(), NOW(), NULL),
(4, 'SAF-002', NULL, 'แว่นตานิรภัย', 'equipment', 'อัน', 40, 15, 'ห้องเซฟตี้', NULL, 'available', NOW(), NOW(), NULL),
(4, 'SAF-003', NULL, 'ถุงมือกันความร้อน', 'consumable', 'คู่', 60, 20, 'ห้องเซฟตี้', NULL, 'available', NOW(), NOW(), NULL),
(4, 'SAF-004', NULL, 'รองเท้าเซฟตี้', 'equipment', 'คู่', 20, 5, 'ห้องเซฟตี้', NULL, 'available', NOW(), NOW(), NULL),
(4, 'SAF-005', NULL, 'ที่อุดหูกันเสียง', 'consumable', 'คู่', 100, 30, 'ห้องเซฟตี้', NULL, 'available', NOW(), NOW(), NULL),

-- เครื่องมือช่าง
(5, 'TLS-001', NULL, 'เครื่องเจียร 4 นิ้ว', 'equipment', 'เครื่อง', 10, 3, 'ห้องเครื่องมือ', NULL, 'available', NOW(), NOW(), NULL),
(5, 'TLS-002', NULL, 'ประแจเลื่อน 12 นิ้ว', 'equipment', 'อัน', 15, 5, 'ห้องเครื่องมือ', NULL, 'available', NOW(), NOW(), NULL),
(5, 'TLS-003', NULL, 'ชุดประแจบล็อก', 'equipment', 'ชุด', 5, 2, 'ห้องเครื่องมือ', NULL, 'available', NOW(), NOW(), NULL),
(5, 'TLS-004', NULL, 'สว่านไฟฟ้า', 'equipment', 'เครื่อง', 8, 2, 'ห้องเครื่องมือ', NULL, 'available', NOW(), NOW(), NULL),
(5, 'TLS-005', NULL, 'ตลับเมตร 5m', 'equipment', 'อัน', 20, 5, 'ห้องเครื่องมือ', NULL, 'available', NOW(), NOW(), NULL),

-- บรรจุภัณฑ์
(6, 'PKG-001', NULL, 'กล่องกระดาษลูกฟูก 60x40x40', 'consumable', 'ใบ', 200, 50, 'คลังบรรจุภัณฑ์', NULL, 'available', NOW(), NOW(), NULL),
(6, 'PKG-002', NULL, 'พลาสติกกันกระแทก', 'consumable', 'ม้วน', 30, 10, 'คลังบรรจุภัณฑ์', NULL, 'available', NOW(), NOW(), NULL),
(6, 'PKG-003', NULL, 'เทปกาวใส 2 นิ้ว', 'consumable', 'ม้วน', 100, 30, 'คลังบรรจุภัณฑ์', NULL, 'available', NOW(), NOW(), NULL),
(6, 'PKG-004', NULL, 'สายรัด PP', 'consumable', 'ม้วน', 25, 5, 'คลังบรรจุภัณฑ์', NULL, 'available', NOW(), NOW(), NULL),

-- อุปกรณ์ไฟฟ้า
(7, 'ELC-001', NULL, 'เบรกเกอร์ 3P 30A', 'consumable', 'ตัว', 10, 3, 'ห้องไฟฟ้า', NULL, 'available', NOW(), NOW(), NULL),
(7, 'ELC-002', NULL, 'สายไฟ VCT 3x2.5 sq.mm.', 'consumable', 'ม้วน', 15, 5, 'ห้องไฟฟ้า', NULL, 'available', NOW(), NOW(), NULL),
(7, 'ELC-003', NULL, 'ปลั๊กอุตสาหกรรม 3P', 'consumable', 'ตัว', 20, 5, 'ห้องไฟฟ้า', NULL, 'available', NOW(), NOW(), NULL),
(7, 'ELC-004', NULL, 'หลอด LED 18W', 'consumable', 'ดวง', 40, 10, 'ห้องไฟฟ้า', NULL, 'available', NOW(), NOW(), NULL),

-- น้ำมันหล่อลื่น
(8, 'LUB-001', NULL, 'น้ำมันเครื่อง SAE 40', 'consumable', 'ลิตร', 50, 10, 'ห้องน้ำมัน', NULL, 'available', NOW(), NOW(), NULL),
(8, 'LUB-002', NULL, 'จารบีอเนกประสงค์', 'consumable', 'กระป๋อง', 30, 10, 'ห้องน้ำมัน', NULL, 'available', NOW(), NOW(), NULL),
(8, 'LUB-003', NULL, 'น้ำมันไฮดรอลิก ISO 46', 'consumable', 'ลิตร', 80, 20, 'ห้องน้ำมัน', NULL, 'available', NOW(), NOW(), NULL),

-- อุปกรณ์สำนักงาน
(9, 'OFF-001', NULL, 'ปากกาลูกลื่น สีน้ำเงิน', 'consumable', 'ด้าม', 100, 20, 'สำนักงาน', NULL, 'available', NOW(), NOW(), NULL),
(9, 'OFF-002', NULL, 'กระดาษ A4 80 แกรม', 'consumable', 'รีม', 50, 10, 'สำนักงาน', NULL, 'available', NOW(), NOW(), NULL),
(9, 'OFF-003', NULL, 'แฟ้มเอกสาร', 'consumable', 'อัน', 40, 10, 'สำนักงาน', NULL, 'available', NOW(), NOW(), NULL),
(9, 'OFF-004', NULL, 'ดินสอ 2B', 'consumable', 'แท่ง', 80, 20, 'สำนักงาน', NULL, 'available', NOW(), NOW(), NULL),

-- อุปกรณ์ทำความสะอาด
(10, 'CLN-001', NULL, 'น้ำยาถูพื้น', 'consumable', 'ลิตร', 30, 5, 'ห้องทำความสะอาด', NULL, 'available', NOW(), NOW(), NULL),
(10, 'CLN-002', NULL, 'ไม้กวาดดอกหญ้า', 'consumable', 'อัน', 15, 5, 'ห้องทำความสะอาด', NULL, 'available', NOW(), NOW(), NULL),
(10, 'CLN-003', NULL, 'ถังขยะ 60 ลิตร', 'equipment', 'ใบ', 10, 3, 'ห้องทำความสะอาด', NULL, 'available', NOW(), NOW(), NULL),
(10, 'CLN-004', NULL, 'ผ้าขี้ริ้ว', 'consumable', 'กก.', 20, 5, 'ห้องทำความสะอาด', NULL, 'available', NOW(), NOW(), NULL);
