<?php
/**
 * Builds $result (mysqli_result) containing active shoes,
 * filtered by optional category (?category=Women/Men/Kids/Unisex)
 * and optional search (?from=search_page&search=...).
 *
 * Requires $conn (mysqli) from db-connect.php
 */

// Inputs
$activeCategory = isset($_GET['category']) ? $_GET['category'] : 'All';
$fromPage       = isset($_GET['from']) ? $_GET['from'] : '';
$searchQuery    = (isset($_GET['search']) && $fromPage === 'search_page') ? trim($_GET['search']) : '';

// Base WHERE
$where  = ["shoe_status = 'Active'"];
$types  = '';
$params = [];

// Category / gender filter (expects column: shoe_gender with values Women/Men/Kids/Unisex)
if (in_array($activeCategory, ['Women','Men','Kids','Unisex'], true)) {
    $where[]  = "shoe_gender = ?";
    $types   .= 's';
    $params[] = $activeCategory;
}

// Search filter
if ($searchQuery !== '') {
    $where[] = "(shoe_name LIKE ? OR shoe_category LIKE ? OR shoe_color LIKE ?)";
    $like = "%{$searchQuery}%";
    $types   .= 'sss';
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
}

// Final SQL
$sql = "SELECT *
        FROM SHOES
        WHERE " . implode(' AND ', $where) . "
        ORDER BY shoe_name ASC";

// Prepare & execute
$stmt = $conn->prepare($sql);
if (!$stmt) {
    // Fallback if prepare fails (rare)
    $result = $conn->query("SELECT * FROM SHOES WHERE shoe_status = 'Active' ORDER BY shoe_name ASC");
    return;
}

if ($types !== '') {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// NOTE: Don't close $stmt here; we let PHP clean it up at the end of the request.
