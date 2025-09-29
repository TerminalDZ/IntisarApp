<?php
require_once '../../init.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'غير مصرح لك بالوصول']);
    exit;
}

// Get action
$action = $_GET['action'] ?? $_POST['action'] ?? '';

// CSRF Protection - Only check for POST requests that require CSRF
$csrf_exempt_actions = ['getStatistics', 'getInventory', 'getTransactions', 'getMemberUniforms', 'getMembers', 'getInventoryItems', 'getSalesByType', 'getMonthlySales', 'getLowStockItems', 'getInventoryDetails'];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !in_array($action, $csrf_exempt_actions) && (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'رمز الحماية غير صحيح']);
    exit;
}

// Check if database connection is valid
if (!$db || $db->connect_errno) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'خطأ في الاتصال بقاعدة البيانات']);
    exit;
}

// Input validation function
function validateRequired($value, $fieldName) {
    if (empty(trim($value))) {
        throw new Exception("الحقل {$fieldName} مطلوب");
    }
    return trim($value);
}

function validateNumeric($value, $fieldName, $min = null, $max = null) {
    if (!is_numeric($value)) {
        throw new Exception("الحقل {$fieldName} يجب أن يكون رقماً");
    }
    
    $num = floatval($value);
    
    if ($min !== null && $num < $min) {
        throw new Exception("الحقل {$fieldName} يجب أن يكون أكبر من أو يساوي {$min}");
    }
    
    if ($max !== null && $num > $max) {
        throw new Exception("الحقل {$fieldName} يجب أن يكون أقل من أو يساوي {$max}");
    }
    
    return $num;
}

function validateInteger($value, $fieldName, $min = null, $max = null) {
    $int = intval($value);
    if ($int != $value) {
        throw new Exception("الحقل {$fieldName} يجب أن يكون عدداً صحيحاً");
    }
    
    if ($min !== null && $int < $min) {
        throw new Exception("الحقل {$fieldName} يجب أن يكون أكبر من أو يساوي {$min}");
    }
    
    if ($max !== null && $int > $max) {
        throw new Exception("الحقل {$fieldName} يجب أن يكون أقل من أو يساوي {$max}");
    }
    
    return $int;
}

function validateDate($date, $fieldName) {
    if (empty($date)) {
        return null;
    }
    
    $d = DateTime::createFromFormat('Y-m-d', $date);
    if (!$d || $d->format('Y-m-d') !== $date) {
        throw new Exception("تنسيق تاريخ الحقل {$fieldName} غير صحيح");
    }
    
    return $date;
}

// Handle different actions
switch ($action) {
    case 'getStatistics':
        getStatistics();
        break;
    
    case 'getInventory':
        getInventory();
        break;
    
    case 'getInventoryItem':
        getInventoryItem();
        break;
    
    case 'getTransactions':
        getTransactions();
        break;
    
    case 'getTransactionDetails':
        getTransactionDetails();
        break;
    
    case 'getMemberUniforms':
        getMemberUniforms();
        break;
    
    case 'getMemberUniformDetails':
        getMemberUniformDetails();
        break;
    
    case 'getMembers':
        getMembers();
        break;
    
    case 'getInventoryItems':
        getInventoryItems();
        break;
    
    case 'getInventoryDetails':
        getInventoryDetails();
        break;
    
    case 'addInventoryItem':
        addInventoryItem();
        break;
    
    case 'updateInventoryItem':
        updateInventoryItem();
        break;
    
    case 'updateStock':
        updateStock();
        break;
    
    case 'deleteInventoryItem':
        deleteInventoryItem();
        break;
    
    case 'addTransaction':
        addTransaction();
        break;
    
    case 'deleteTransaction':
        deleteTransaction();
        break;
    
    case 'getSalesByType':
        getSalesByType();
        break;
    
    case 'getMonthlySales':
        getMonthlySales();
        break;
    
    case 'getLowStockItems':
        getLowStockItems();
        break;
    
    default:
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'عملية غير صحيحة']);
        break;
}

// Statistics Functions
function getStatistics() {
    global $db;
    
    // Check if database connection is valid
    if (!$db || $db->connect_errno) {
        echo json_encode(['success' => false, 'message' => 'خطأ في الاتصال بقاعدة البيانات']);
        return;
    }
    
    try {
        // Total inventory items
        $result = $db->query("SELECT COUNT(*) as total FROM uniform_inventory");
        if ($result === false) {
            throw new Exception('خطأ في الاستعلام: ' . $db->error);
        }
        $totalInventoryItems = $result->fetch_assoc()['total'];
        
        // Total sales
        $result = $db->query("SELECT COUNT(*) as total FROM uniform_transactions WHERE transaction_type = 'بيع'");
        if ($result === false) {
            throw new Exception('خطأ في الاستعلام: ' . $db->error);
        }
        $totalSales = $result->fetch_assoc()['total'];
        
        // Pending payments
        $result = $db->query("SELECT COUNT(*) as total FROM uniform_transactions WHERE payment_status != 'مدفوع'");
        if ($result === false) {
            throw new Exception('خطأ في الاستعلام: ' . $db->error);
        }
        $pendingPayments = $result->fetch_assoc()['total'];
        
        // Low stock items
        $result = $db->query("SELECT COUNT(*) as total FROM uniform_inventory WHERE quantity_in_stock <= min_stock_level");
        if ($result === false) {
            throw new Exception('خطأ في الاستعلام: ' . $db->error);
        }
        $lowStockItems = $result->fetch_assoc()['total'];
        
        echo json_encode([
            'success' => true,
            'data' => [
                'totalInventoryItems' => (int)$totalInventoryItems,
                'totalSales' => (int)$totalSales,
                'pendingPayments' => (int)$pendingPayments,
                'lowStockItems' => (int)$lowStockItems
            ]
        ]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'خطأ في جلب الإحصائيات: ' . $e->getMessage()]);
    }
}

// Inventory Functions
function getInventory() {
    global $db;
    
    // Check if database connection is valid
    if (!$db || $db->connect_errno) {
        echo json_encode(['success' => false, 'message' => 'خطأ في الاتصال بقاعدة البيانات']);
        return;
    }
    
    try {
        // DataTables parameters
        $draw = intval($_POST['draw'] ?? 1);
        $start = intval($_POST['start'] ?? 0);
        $length = intval($_POST['length'] ?? 25);
        $searchValue = $_POST['search']['value'] ?? '';
        
        // Base query
        $baseQuery = "FROM uniform_inventory WHERE 1=1";
        $params = [];
        $types = "";
        
        // Search filter
        if (!empty($searchValue)) {
            $baseQuery .= " AND (item_name LIKE ? OR item_type LIKE ? OR size LIKE ? OR supplier LIKE ?)";
            $searchParam = "%{$searchValue}%";
            $params = array_merge($params, [$searchParam, $searchParam, $searchParam, $searchParam]);
            $types = "ssss";
        }
        
        // Count total records
        $countQuery = "SELECT COUNT(*) as total " . $baseQuery;
        if (!empty($params)) {
            $stmt = $db->prepare($countQuery);
            if ($stmt === false) {
                throw new Exception('خطأ في تحضير الاستعلام: ' . $db->error);
            }
            if ($types) {
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $result = $db->query($countQuery);
            if ($result === false) {
                throw new Exception('خطأ في الاستعلام: ' . $db->error);
            }
        }
        $totalRecords = $result->fetch_assoc()['total'];
        
        // Get data with pagination
        $dataQuery = "SELECT * " . $baseQuery . " ORDER BY item_name ASC LIMIT ? OFFSET ?";
        $params[] = $length;
        $params[] = $start;
        $types .= "ii";
        
        $stmt = $db->prepare($dataQuery);
        if ($stmt === false) {
            throw new Exception('خطأ في تحضير الاستعلام: ' . $db->error);
        }
        if ($types) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        echo json_encode([
            'draw' => $draw,
            'recordsTotal' => (int)$totalRecords,
            'recordsFiltered' => (int)$totalRecords,
            'data' => $data
        ]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'خطأ في جلب بيانات المخزون: ' . $e->getMessage()]);
    }
}

function getInventoryItem() {
    global $db;
    
    try {
        $id = intval($_GET['id'] ?? 0);
        
        if ($id <= 0) {
            echo json_encode(['success' => false, 'message' => 'معرف غير صحيح']);
            return;
        }
        
        $stmt = $db->prepare("
            SELECT * FROM uniform_inventory 
            WHERE id = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $item = $result->fetch_assoc();
        
        if (!$item) {
            echo json_encode(['success' => false, 'message' => 'الصنف غير موجود']);
            return;
        }
        
        echo json_encode(['success' => true, 'data' => $item]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'خطأ في جلب بيانات الصنف']);
    }
}

function addInventoryItem() {
    global $db;
    
    try {
        // Validate inputs
        $itemName = validateRequired($_POST['item_name'] ?? '', 'اسم الصنف');
        $itemType = validateRequired($_POST['item_type'] ?? '', 'نوع الصنف');
        $size = validateRequired($_POST['size'] ?? '', 'المقاس');
        $quantityInStock = validateInteger($_POST['quantity_in_stock'] ?? 0, 'الكمية في المخزون', 0);
        $minStockLevel = validateInteger($_POST['min_stock_level'] ?? 0, 'الحد الأدنى للمخزون', 0);
        $unitPrice = validateNumeric($_POST['unit_price'] ?? 0, 'سعر الوحدة', 0);
        $supplier = $_POST['supplier'] ?? '';
        $purchaseDate = validateDate($_POST['purchase_date'] ?? '', 'تاريخ الشراء');
        $notes = $_POST['notes'] ?? '';
        
        $stmt = $db->prepare("
            INSERT INTO uniform_inventory 
            (item_name, item_type, size, quantity_in_stock, min_stock_level, unit_price, supplier, purchase_date, notes) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->bind_param("sssiiisss", $itemName, $itemType, $size, $quantityInStock, $minStockLevel, $unitPrice, $supplier, $purchaseDate, $notes);
        $stmt->execute();
        
        echo json_encode(['success' => true, 'message' => 'تم إضافة الصنف بنجاح']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

function updateInventoryItem() {
    global $db;
    
    try {
        // Validate inputs
        $id = validateInteger($_POST['id'] ?? 0, 'معرف الصنف', 1);
        $itemName = validateRequired($_POST['item_name'] ?? '', 'اسم الصنف');
        $itemType = validateRequired($_POST['item_type'] ?? '', 'نوع الصنف');
        $size = validateRequired($_POST['size'] ?? '', 'المقاس');
        $quantityInStock = validateInteger($_POST['quantity_in_stock'] ?? 0, 'الكمية في المخزون', 0);
        $unitPrice = validateNumeric($_POST['unit_price'] ?? 0, 'سعر الوحدة', 0);
        $supplier = $_POST['supplier'] ?? '';
        $purchaseDate = validateDate($_POST['purchase_date'] ?? '', 'تاريخ الشراء');
        $notes = $_POST['notes'] ?? '';
        
        $stmt = $db->prepare("
            UPDATE uniform_inventory 
            SET item_name = ?, item_type = ?, size = ?, quantity_in_stock = ?, 
                unit_price = ?, supplier = ?, purchase_date = ?, notes = ?
            WHERE id = ?
        ");
        
        $stmt->bind_param("sssdisssi", $itemName, $itemType, $size, $quantityInStock, $unitPrice, $supplier, $purchaseDate, $notes, $id);
        $stmt->execute();
        
        // Check if any rows were affected
        if ($stmt->affected_rows === 0) {
            throw new Exception('لم يتم العثور على الصنف المحدد');
        }
        
        echo json_encode(['success' => true, 'message' => 'تم تحديث الصنف بنجاح']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

function updateStock() {
    global $db;
    
    try {
        // Validate inputs
        $inventoryId = validateInteger($_POST['inventory_id'] ?? 0, 'معرف المخزون', 1);
        $quantityChange = validateInteger($_POST['quantity_added'] ?? 0, 'كمية التحديث', 1);
        $reason = $_POST['notes'] ?? '';
        
        // Get current stock
        $stmt = $db->prepare("SELECT quantity_in_stock FROM uniform_inventory WHERE id = ?");
        $stmt->bind_param("i", $inventoryId);
        $stmt->execute();
        $result = $stmt->get_result();
        $currentStock = $result->fetch_assoc();
        
        if (!$currentStock) {
            throw new Exception('الصنف غير موجود');
        }
        
        // Calculate new quantity
        $newQuantity = $currentStock['quantity_in_stock'] + $quantityChange;
        
        // Update stock
        $stmt = $db->prepare("UPDATE uniform_inventory SET quantity_in_stock = ? WHERE id = ?");
        $stmt->bind_param("ii", $newQuantity, $inventoryId);
        $stmt->execute();
        
        // Check if any rows were affected
        if ($stmt->affected_rows === 0) {
            throw new Exception('لم يتم تحديث المخزون');
        }
        
        echo json_encode(['success' => true, 'message' => 'تم تحديث المخزون بنجاح']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

function deleteInventoryItem() {
    global $db;
    
    try {
        $id = validateInteger($_POST['id'] ?? 0, 'معرف الصنف', 1);
        
        // Check if item has transactions
        $stmt = $db->prepare("SELECT COUNT(*) as count FROM uniform_transactions WHERE inventory_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $transactionCount = $result->fetch_assoc()['count'];
        
        if ($transactionCount > 0) {
            echo json_encode(['success' => false, 'message' => 'لا يمكن حذف هذا الصنف لوجود معاملات مرتبطة به']);
            return;
        }
        
        $stmt = $db->prepare("DELETE FROM uniform_inventory WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        // Check if any rows were affected
        if ($stmt->affected_rows === 0) {
            throw new Exception('لم يتم حذف الصنف');
        }
        
        echo json_encode(['success' => true, 'message' => 'تم حذف الصنف بنجاح']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

// Transaction Functions
function getTransactions() {
    global $db;
    
    // Check if database connection is valid
    if (!$db || $db->connect_errno) {
        echo json_encode(['success' => false, 'message' => 'خطأ في الاتصال بقاعدة البيانات']);
        return;
    }
    
    try {
        // DataTables parameters
        $draw = intval($_POST['draw'] ?? 1);
        $start = intval($_POST['start'] ?? 0);
        $length = intval($_POST['length'] ?? 25);
        $searchValue = $_POST['search']['value'] ?? '';
        
        // Filters
        $transactionType = $_POST['transaction_type'] ?? '';
        $paymentStatus = $_POST['payment_status'] ?? '';
        $dateFrom = $_POST['date_from'] ?? '';
        $dateTo = $_POST['date_to'] ?? '';
        
        // Base query
        $baseQuery = "
            FROM uniform_transactions ut 
            JOIN uniform_inventory ui ON ut.inventory_id = ui.id 
            WHERE 1=1
        ";
        $params = [];
        $types = "";
        
        // Search filter
        if (!empty($searchValue)) {
            $baseQuery .= " AND (ut.member_id LIKE ? OR ui.item_name LIKE ? OR ui.item_type LIKE ?)";
            $searchParam = "%{$searchValue}%";
            $params = array_merge($params, [$searchParam, $searchParam, $searchParam]);
            $types = "sss";
        }
        
        // Transaction type filter
        if (!empty($transactionType)) {
            $baseQuery .= " AND ut.transaction_type = ?";
            $params[] = $transactionType;
            $types .= "s";
        }
        
        // Payment status filter
        if (!empty($paymentStatus)) {
            $baseQuery .= " AND ut.payment_status = ?";
            $params[] = $paymentStatus;
            $types .= "s";
        }
        
        // Date filters
        if (!empty($dateFrom)) {
            $baseQuery .= " AND DATE(ut.transaction_date) >= ?";
            $params[] = $dateFrom;
            $types .= "s";
        }
        
        if (!empty($dateTo)) {
            $baseQuery .= " AND DATE(ut.transaction_date) <= ?";
            $params[] = $dateTo;
            $types .= "s";
        }
        
        // Count total records
        $countQuery = "SELECT COUNT(*) as total " . $baseQuery;
        if (!empty($params)) {
            $stmt = $db->prepare($countQuery);
            if ($stmt === false) {
                throw new Exception('خطأ في تحضير الاستعلام: ' . $db->error);
            }
            if ($types) {
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $result = $db->query($countQuery);
            if ($result === false) {
                throw new Exception('خطأ في الاستعلام: ' . $db->error);
            }
        }
        $totalRecords = $result->fetch_assoc()['total'];
        
        // Get data with pagination
        $dataQuery = "
            SELECT ut.*, ui.item_name, ui.item_type, ui.size 
            " . $baseQuery . " 
            ORDER BY ut.transaction_date DESC 
            LIMIT ? OFFSET ?
        ";
        $params[] = $length;
        $params[] = $start;
        $types .= "ii";
        
        $stmt = $db->prepare($dataQuery);
        if ($stmt === false) {
            throw new Exception('خطأ في تحضير الاستعلام: ' . $db->error);
        }
        if ($types) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        echo json_encode([
            'draw' => $draw,
            'recordsTotal' => (int)$totalRecords,
            'recordsFiltered' => (int)$totalRecords,
            'data' => $data
        ]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'خطأ في جلب بيانات المعاملات: ' . $e->getMessage()]);
    }
}

function getTransactionDetails() {
    global $db;
    
    try {
        $id = intval($_GET['id'] ?? 0);
        
        if ($id <= 0) {
            echo json_encode(['success' => false, 'message' => 'معرف المعاملة غير صحيح']);
            return;
        }
        
        $stmt = $db->prepare("
            SELECT ut.*, 
                   ui.item_name, ui.item_type, ui.size,
                   CONCAT(m.first_name, ' ', m.last_name) as member_name
            FROM uniform_transactions ut
            JOIN uniform_inventory ui ON ut.inventory_id = ui.id
            JOIN members m ON ut.member_id = m.id
            WHERE ut.id = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $transaction = $result->fetch_assoc();
        
        if (!$transaction) {
            echo json_encode(['success' => false, 'message' => 'المعاملة غير موجودة']);
            return;
        }
        
        // Format dates
        $transaction['transaction_date'] = date('Y-m-d', strtotime($transaction['transaction_date']));
        
        echo json_encode(['success' => true, 'data' => $transaction]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'خطأ في جلب تفاصيل المعاملة']);
    }
}

function addTransaction() {
    global $db;
    
    try {
        // Validate inputs
        $memberId = validateRequired($_POST['member_id'] ?? '', 'معرف المنخرط');
        $inventoryId = validateInteger($_POST['inventory_id'] ?? 0, 'معرف المخزون', 1);
        $transactionType = validateRequired($_POST['transaction_type'] ?? '', 'نوع المعاملة');
        $quantity = validateInteger($_POST['quantity'] ?? 0, 'الكمية', 1);
        $unitPrice = validateNumeric($_POST['unit_price'] ?? 0, 'سعر الوحدة', 0);
        $totalAmount = validateNumeric($_POST['total_amount'] ?? 0, 'المبلغ الإجمالي', 0);
        $paymentStatus = validateRequired($_POST['payment_status'] ?? '', 'حالة الدفع');
        $amountPaid = validateNumeric($_POST['amount_paid'] ?? 0, 'المبلغ المدفوع', 0);
        $paymentMethod = $_POST['payment_method'] ?? '';
        $notes = $_POST['notes'] ?? '';
        
        // Validate transaction type
        $validTransactionTypes = ['بيع', 'استلام', 'إرجاع', 'تلف', 'فقدان'];
        if (!in_array($transactionType, $validTransactionTypes)) {
            throw new Exception('نوع المعاملة غير صحيح');
        }
        
        // Validate payment status
        $validPaymentStatuses = ['مدفوع', 'مدفوع جزئياً', 'غير مدفوع'];
        if (!in_array($paymentStatus, $validPaymentStatuses)) {
            throw new Exception('حالة الدفع غير صحيحة');
        }
        
        // Check if member exists
        $stmt = $db->prepare("SELECT id FROM members WHERE id = ?");
        $stmt->bind_param("s", $memberId);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result->fetch_assoc()) {
            throw new Exception('المنخرط غير موجود');
        }
        
        // Check inventory availability for sales
        if ($transactionType === 'بيع') {
            $stmt = $db->prepare("SELECT quantity_in_stock FROM uniform_inventory WHERE id = ?");
            $stmt->bind_param("i", $inventoryId);
            $stmt->execute();
            $result = $stmt->get_result();
            $inventory = $result->fetch_assoc();
            
            if (!$inventory || $inventory['quantity_in_stock'] < $quantity) {
                throw new Exception('الكمية المطلوبة غير متوفرة في المخزون');
            }
        }
        
        $db->begin_transaction();
        
        // Add transaction
        $stmt = $db->prepare("
            INSERT INTO uniform_transactions 
            (member_id, inventory_id, transaction_type, quantity, unit_price, total_amount, payment_status, amount_paid, payment_method, notes) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->bind_param("siisiddsss", $memberId, $inventoryId, $transactionType, $quantity, $unitPrice, $totalAmount, $paymentStatus, $amountPaid, $paymentMethod, $notes);
        $stmt->execute();
        
        // Update inventory stock
        if ($transactionType === 'بيع') {
            $stmt = $db->prepare("UPDATE uniform_inventory SET quantity_in_stock = quantity_in_stock - ? WHERE id = ?");
            $stmt->bind_param("ii", $quantity, $inventoryId);
            $stmt->execute();
        } elseif ($transactionType === 'إرجاع') {
            $stmt = $db->prepare("UPDATE uniform_inventory SET quantity_in_stock = quantity_in_stock + ? WHERE id = ?");
            $stmt->bind_param("ii", $quantity, $inventoryId);
            $stmt->execute();
        }
        
        $db->commit();
        
        echo json_encode(['success' => true, 'message' => 'تم حفظ المعاملة بنجاح']);
    } catch (Exception $e) {
        $db->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

function deleteTransaction() {
    global $db;
    
    try {
        // Validate input
        $id = validateInteger($_POST['id'] ?? 0, 'معرف المعاملة', 1);
        
        // Get transaction details
        $stmt = $db->prepare("SELECT * FROM uniform_transactions WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $transaction = $result->fetch_assoc();
        
        if (!$transaction) {
            throw new Exception('المعاملة غير موجودة');
        }
        
        $db->begin_transaction();
        
        // Reverse inventory changes
        if ($transaction['transaction_type'] === 'بيع') {
            $stmt = $db->prepare("UPDATE uniform_inventory SET quantity_in_stock = quantity_in_stock + ? WHERE id = ?");
            $stmt->bind_param("ii", $transaction['quantity'], $transaction['inventory_id']);
            $stmt->execute();
        } elseif ($transaction['transaction_type'] === 'إرجاع') {
            $stmt = $db->prepare("UPDATE uniform_inventory SET quantity_in_stock = quantity_in_stock - ? WHERE id = ?");
            $stmt->bind_param("ii", $transaction['quantity'], $transaction['inventory_id']);
            $stmt->execute();
        }
        
        // Delete transaction
        $stmt = $db->prepare("DELETE FROM uniform_transactions WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        // Check if any rows were affected
        if ($stmt->affected_rows === 0) {
            throw new Exception('لم يتم حذف المعاملة');
        }
        
        $db->commit();
        
        echo json_encode(['success' => true, 'message' => 'تم حذف المعاملة بنجاح']);
    } catch (Exception $e) {
        $db->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

// Member Uniform Functions
function getMemberUniforms() {
    global $db;
    
    // Check if database connection is valid
    if (!$db || $db->connect_errno) {
        echo json_encode(['success' => false, 'message' => 'خطأ في الاتصال بقاعدة البيانات']);
        return;
    }
    
    try {
        // DataTables parameters
        $draw = intval($_POST['draw'] ?? 1);
        $start = intval($_POST['start'] ?? 0);
        $length = intval($_POST['length'] ?? 25);
        $searchValue = $_POST['search']['value'] ?? '';
        $searchMember = $_POST['search_member'] ?? '';
        
        // Base query
        $baseQuery = "FROM members m WHERE 1=1";
        $params = [];
        $types = "";
        
        // Search filters
        if (!empty($searchValue)) {
            $baseQuery .= " AND (m.id LIKE ? OR m.first_name LIKE ? OR m.last_name LIKE ?)";
            $searchParam = "%{$searchValue}%";
            $params = array_merge($params, [$searchParam, $searchParam, $searchParam]);
            $types = "sss";
        }
        
        if (!empty($searchMember)) {
            $baseQuery .= " AND (m.id LIKE ? OR m.first_name LIKE ? OR m.last_name LIKE ?)";
            $searchParam = "%{$searchMember}%";
            $params = array_merge($params, [$searchParam, $searchParam, $searchParam]);
            if ($types) {
                $types .= "sss";
            } else {
                $types = "sss";
            }
        }
        
        // Count total records
        $countQuery = "SELECT COUNT(*) as total " . $baseQuery;
        if (!empty($params)) {
            $stmt = $db->prepare($countQuery);
            if ($stmt === false) {
                throw new Exception('خطأ في تحضير الاستعلام: ' . $db->error);
            }
            if ($types) {
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $result = $db->query($countQuery);
            if ($result === false) {
                throw new Exception('خطأ في الاستعلام: ' . $db->error);
            }
        }
        $totalRecords = $result->fetch_assoc()['total'];
        
        // Get data with pagination
        $dataQuery = "
            SELECT m.id as member_id, 
                   CONCAT(m.first_name, ' ', m.last_name) as full_name,
                   COALESCE(SUM(CASE WHEN ut.transaction_type = 'بيع' THEN ut.amount_paid ELSE 0 END), 0) as total_paid,
                   COALESCE(SUM(CASE WHEN ut.transaction_type = 'بيع' AND ut.payment_status != 'مدفوع' THEN ut.total_amount - ut.amount_paid ELSE 0 END), 0) as amount_due
            " . $baseQuery . "
            LEFT JOIN uniform_transactions ut ON m.id = ut.member_id
            GROUP BY m.id, m.first_name, m.last_name
            ORDER BY m.id ASC 
            LIMIT ? OFFSET ?
        ";
        $params[] = $length;
        $params[] = $start;
        $types .= "ii";
        
        $stmt = $db->prepare($dataQuery);
        if ($stmt === false) {
            throw new Exception('خطأ في تحضير الاستعلام: ' . $db->error);
        }
        if ($types) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        // Get uniforms for each member
        foreach ($data as &$member) {
            $uniformStmt = $db->prepare("
                SELECT ui.item_type, ui.size, ut.quantity
                FROM uniform_transactions ut
                JOIN uniform_inventory ui ON ut.inventory_id = ui.id
                WHERE ut.member_id = ?
            ");
            if ($uniformStmt === false) {
                throw new Exception('خطأ في تحضير الاستعلام: ' . $db->error);
            }
            $uniformStmt->bind_param("s", $member['member_id']);
            $uniformStmt->execute();
            $uniformResult = $uniformStmt->get_result();
            
            $uniforms = [];
            while ($uniformRow = $uniformResult->fetch_assoc()) {
                $uniforms[] = $uniformRow;
            }
            $member['uniforms_owned'] = $uniforms;
        }
        
        echo json_encode([
            'draw' => $draw,
            'recordsTotal' => (int)$totalRecords,
            'recordsFiltered' => (int)$totalRecords,
            'data' => $data
        ]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'خطأ في جلب بيانات أزياء المنخرطين: ' . $e->getMessage()]);
    }
}

function getMemberUniformDetails() {
    global $db;
    
    try {
        $memberId = $_GET['member_id'] ?? '';
        
        if (empty($memberId)) {
            echo json_encode(['success' => false, 'message' => 'معرف المنخرط غير صحيح']);
            return;
        }
        
        // Get member info
        $stmt = $db->prepare("
            SELECT id as member_id, CONCAT(first_name, ' ', last_name) as full_name
            FROM members 
            WHERE id = ?
        ");
        $stmt->bind_param("s", $memberId);
        $stmt->execute();
        $result = $stmt->get_result();
        $member = $result->fetch_assoc();
        
        if (!$member) {
            echo json_encode(['success' => false, 'message' => 'المنخرط غير موجود']);
            return;
        }
        
        // Get payment info
        $stmt = $db->prepare("
            SELECT 
                COALESCE(SUM(CASE WHEN ut.transaction_type = 'بيع' THEN ut.amount_paid ELSE 0 END), 0) as total_paid,
                COALESCE(SUM(CASE WHEN ut.transaction_type = 'بيع' AND ut.payment_status != 'مدفوع' THEN ut.total_amount - ut.amount_paid ELSE 0 END), 0) as amount_due
            FROM uniform_transactions ut
            WHERE ut.member_id = ?
        ");
        $stmt->bind_param("s", $memberId);
        $stmt->execute();
        $result = $stmt->get_result();
        $paymentInfo = $result->fetch_assoc();
        
        $member['total_paid'] = $paymentInfo['total_paid'];
        $member['amount_due'] = $paymentInfo['amount_due'];
        
        // Get uniforms owned
        $stmt = $db->prepare("
            SELECT ui.item_name, ui.item_type, ui.size, ut.quantity, ut.unit_price, ut.total_amount, 
                   DATE(ut.transaction_date) as transaction_date
            FROM uniform_transactions ut
            JOIN uniform_inventory ui ON ut.inventory_id = ui.id
            WHERE ut.member_id = ? AND ut.transaction_type = 'بيع'
            ORDER BY ut.transaction_date DESC
        ");
        $stmt->bind_param("s", $memberId);
        $stmt->execute();
        $result = $stmt->get_result();
        $uniforms = [];
        while ($row = $result->fetch_assoc()) {
            $uniforms[] = $row;
        }
        $member['uniforms'] = $uniforms;
        
        echo json_encode(['success' => true, 'data' => $member]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'خطأ في جلب تفاصيل أزياء المنخرط']);
    }
}

// Helper Functions
function getMembers() {
    global $db;
    
    // Check if database connection is valid
    if (!$db || $db->connect_errno) {
        echo json_encode(['success' => false, 'message' => 'خطأ في الاتصال بقاعدة البيانات']);
        return;
    }
    
    try {
        $result = $db->query("SELECT id, CONCAT(first_name, ' ', last_name) as full_name FROM members ORDER BY first_name, last_name");
        if ($result === false) {
            throw new Exception('خطأ في الاستعلام: ' . $db->error);
        }
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        echo json_encode(['success' => true, 'data' => $data]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'خطأ في جلب بيانات المنخرطين: ' . $e->getMessage()]);
    }
}

function getInventoryItems() {
    global $db;
    
    // Check if database connection is valid
    if (!$db || $db->connect_errno) {
        echo json_encode(['success' => false, 'message' => 'خطأ في الاتصال بقاعدة البيانات']);
        return;
    }
    
    try {
        $result = $db->query("SELECT id, item_name, item_type, size, unit_price, quantity_in_stock FROM uniform_inventory WHERE quantity_in_stock > 0 ORDER BY item_name, item_type, size");
        if ($result === false) {
            throw new Exception('خطأ في الاستعلام: ' . $db->error);
        }
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        echo json_encode(['success' => true, 'data' => $data]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'خطأ في جلب بيانات المخزون: ' . $e->getMessage()]);
    }
}

function getInventoryDetails() {
    global $db;
    
    // Check if database connection is valid
    if (!$db || $db->connect_errno) {
        echo json_encode(['success' => false, 'message' => 'خطأ في الاتصال بقاعدة البيانات']);
        return;
    }
    
    try {
        $inventoryId = intval($_POST['inventory_id'] ?? 0);
        
        if ($inventoryId <= 0) {
            echo json_encode(['success' => false, 'message' => 'معرف المخزون غير صحيح']);
            return;
        }
        
        $stmt = $db->prepare("
            SELECT id, item_name, item_type, size, unit_price, quantity_in_stock 
            FROM uniform_inventory 
            WHERE id = ?
        ");
        if ($stmt === false) {
            throw new Exception('خطأ في تحضير الاستعلام: ' . $db->error);
        }
        $stmt->bind_param("i", $inventoryId);
        $stmt->execute();
        $result = $stmt->get_result();
        $item = $result->fetch_assoc();
        
        if (!$item) {
            echo json_encode(['success' => false, 'message' => 'الصنف غير موجود']);
            return;
        }
        
        echo json_encode(['success' => true, 'data' => $item]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'خطأ في جلب تفاصيل الصنف: ' . $e->getMessage()]);
    }
}

// Report Functions
function getSalesByType() {
    global $db;
    
    // Check if database connection is valid
    if (!$db || $db->connect_errno) {
        echo json_encode(['success' => false, 'message' => 'خطأ في الاتصال بقاعدة البيانات']);
        return;
    }
    
    try {
        $result = $db->query("
            SELECT ui.item_type, SUM(ut.quantity) as total_sold
            FROM uniform_transactions ut
            JOIN uniform_inventory ui ON ut.inventory_id = ui.id
            WHERE ut.transaction_type = 'بيع'
            GROUP BY ui.item_type
            ORDER BY total_sold DESC
        ");
        
        if ($result === false) {
            throw new Exception('خطأ في الاستعلام: ' . $db->error);
        }
        
        $labels = [];
        $values = [];
        
        while ($row = $result->fetch_assoc()) {
            $labels[] = $row['item_type'];
            $values[] = (int)$row['total_sold'];
        }
        
        echo json_encode([
            'success' => true,
            'data' => [
                'labels' => $labels,
                'values' => $values
            ]
        ]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'خطأ في جلب بيانات المبيعات: ' . $e->getMessage()]);
    }
}

function getMonthlySales() {
    global $db;
    
    // Check if database connection is valid
    if (!$db || $db->connect_errno) {
        echo json_encode(['success' => false, 'message' => 'خطأ في الاتصال بقاعدة البيانات']);
        return;
    }
    
    try {
        $result = $db->query("
            SELECT DATE_FORMAT(transaction_date, '%Y-%m') as month, 
                   SUM(total_amount) as total_sales
            FROM uniform_transactions 
            WHERE transaction_type = 'بيع' 
              AND transaction_date >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
            GROUP BY DATE_FORMAT(transaction_date, '%Y-%m')
            ORDER BY month ASC
        ");
        
        if ($result === false) {
            throw new Exception('خطأ في الاستعلام: ' . $db->error);
        }
        
        $labels = [];
        $values = [];
        
        while ($row = $result->fetch_assoc()) {
            $labels[] = $row['month'];
            $values[] = (float)$row['total_sales'];
        }
        
        echo json_encode([
            'success' => true,
            'data' => [
                'labels' => $labels,
                'values' => $values
            ]
        ]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'خطأ في جلب بيانات المبيعات الشهرية: ' . $e->getMessage()]);
    }
}

function getLowStockItems() {
    global $db;
    
    // Check if database connection is valid
    if (!$db || $db->connect_errno) {
        echo json_encode(['success' => false, 'message' => 'خطأ في الاتصال بقاعدة البيانات']);
        return;
    }
    
    try {
        $result = $db->query("
            SELECT item_name, item_type, size, quantity_in_stock, min_stock_level
            FROM uniform_inventory 
            WHERE quantity_in_stock <= min_stock_level
            ORDER BY quantity_in_stock ASC
        ");
        
        if ($result === false) {
            throw new Exception('خطأ في الاستعلام: ' . $db->error);
        }
        
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        echo json_encode(['success' => true, 'data' => $data]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'خطأ في جلب بيانات المخزون المنخفض: ' . $e->getMessage()]);
    }
}
?>
