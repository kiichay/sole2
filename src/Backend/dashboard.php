<?php
// ==============================================
// FOR FETCHING BEST SELLING, LATEST PRODUCT AND FOR FILTERING ON SEARCH
// ==============================================

// Get the search query from GET (if any)
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
$searchTerm  = $conn->real_escape_string($searchQuery); // escape to prevent SQL injection

// ============================================================
// BEST SELLING PRODUCTS (Top 10 by checkouts + rating)
// ============================================================
$sql_best_selling = "
    SELECT s.shoe_id, s.shoe_name, s.shoe_price, s.shoe_checkouts, 
           s.shoe_rating, s.shoe_image, s.shoe_sale_price
    FROM (
        SELECT shoe_id
        FROM shoes
        WHERE shoe_status = 'Active'
        ORDER BY shoe_checkouts DESC, shoe_rating DESC
        LIMIT 10
    ) AS top_sellers
    INNER JOIN shoes s ON s.shoe_id = top_sellers.shoe_id
    WHERE s.shoe_status = 'Active'
";

// Apply search filter ONLY inside best sellers
if (!empty($searchTerm)) {
    $sql_best_selling .= " AND (s.shoe_name LIKE '%$searchTerm%' 
                            OR s.shoe_category LIKE '%$searchTerm%' 
                            OR s.shoe_color LIKE '%$searchTerm%')";
}

$sql_best_selling .= " ORDER BY s.shoe_checkouts DESC, s.shoe_rating DESC";

$bestSellingResult = $conn->query($sql_best_selling);

// ============================================================
// LATEST PRODUCTS (Top 10 newest by created_at)
// ============================================================
$sql_latest_products = "
    SELECT s.shoe_id, s.shoe_name, s.shoe_price, s.shoe_checkouts, 
           s.shoe_rating, s.shoe_image, s.shoe_sale_price, s.created_at
    FROM (
        SELECT shoe_id
        FROM shoes
        WHERE shoe_status = 'Active'
        ORDER BY created_at DESC, shoe_rating DESC, shoe_checkouts DESC
        LIMIT 10
    ) AS newest
    INNER JOIN shoes s ON s.shoe_id = newest.shoe_id
    WHERE s.shoe_status = 'Active'
";

// Apply search filter for latest too
if (!empty($searchTerm)) {
    $sql_latest_products .= " AND (s.shoe_name LIKE '%$searchTerm%' 
                                OR s.shoe_category LIKE '%$searchTerm%' 
                                OR s.shoe_color LIKE '%$searchTerm%')";
}

$sql_latest_products .= " ORDER BY s.created_at DESC, s.shoe_rating DESC, s.shoe_checkouts DESC";

$latestProductsResult = $conn->query($sql_latest_products);

// ============================================================
// FOR PROFILE PART
// ============================================================ 
?>
