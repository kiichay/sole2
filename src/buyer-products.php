<?php
// ===== includes & setup =====
include './db-connect.php';   // DB connection ($conn)
include './sidebar.php';      // Left sidebar markup

// For highlighting the active tab
$activeCategory = isset($_GET['category']) ? $_GET['category'] : 'All';

// Build $result from DB (category + search handled inside)
include './Backend/products.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Buyer Products</title>
  <link href="./output.css" rel="stylesheet"> 
  <link href="./styles/buyer-products.css" rel="stylesheet">
</head>

<body class="flex h-screen bg-[#dbc4a1]">
  <!-- Main Content Area -->
  <div class="flex-1 flex flex-col ml-1/5">
    <!-- Top Navbar -->
    <?php include './navbar.php'; ?>

    <!-- Category Navbar -->
    <nav class="category-navbar bg-[#d2b58b] p-2 flex justify-between items-center">
      <a href="buyer-products.php"
         class="category-btn <?= $activeCategory === 'All' ? 'active' : '' ?>"
         aria-current="<?= $activeCategory === 'All' ? 'page' : 'false' ?>">
        All Products
      </a>

      <a href="buyer-products.php?category=Women"
         class="category-btn <?= $activeCategory === 'Women' ? 'active' : '' ?>"
         aria-current="<?= $activeCategory === 'Women' ? 'page' : 'false' ?>">
        Women
      </a>

      <a href="buyer-products.php?category=Men"
         class="category-btn <?= $activeCategory === 'Men' ? 'active' : '' ?>"
         aria-current="<?= $activeCategory === 'Men' ? 'page' : 'false' ?>">
        Men
      </a>

      <a href="buyer-products.php?category=Kids"
         class="category-btn <?= $activeCategory === 'Kids' ? 'active' : '' ?>"
         aria-current="<?= $activeCategory === 'Kids' ? 'page' : 'false' ?>">
        Kids
      </a>

      <a href="buyer-products.php?category=Unisex"
         class="category-btn flex items-center gap-2 <?= $activeCategory === 'Unisex' ? 'active' : '' ?>"
         aria-current="<?= $activeCategory === 'Unisex' ? 'page' : 'false' ?>">
        <img src="./img/filter.png" alt="Filter" class="w-4 h-4" /> Unisex
      </a>
    </nav>

    <!-- Content Area -->
    <main class="main-content p-4">
      <div class="product-list grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
        <?php 
          if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $isOnSale = isset($row['shoe_sale_price']) && $row['shoe_sale_price'] !== null && $row['shoe_sale_price'] < $row['shoe_price'];
              ?>
              <div class="product-item bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300 ease-in-out relative">
                <?php if ($isOnSale): ?>
                  <div class="sale-banner absolute top-0 left-0 bg-red-500 text-white px-2 py-1 text-xs font-bold uppercase">Sale</div>
                <?php endif; ?>

                <img src="<?= htmlspecialchars($row['shoe_image']) ?>" alt="<?= htmlspecialchars($row['shoe_name']) ?>" class="w-full h-48 object-cover" />

                <div class="product-info p-4 text-center">
                  <h3 class="product-name text-xl font-bold text-[#3E2723] mb-2"><?= htmlspecialchars($row['shoe_name']) ?></h3>

                  <?php if ($isOnSale): ?>
                    <p class="sale-price text-xl font-semibold text-[#f39c12]">Php <?= number_format((float)$row['shoe_sale_price'], 2) ?></p>
                    <p class="regular-price text-sm font-semibold line-through text-gray-500">Php <?= number_format((float)$row['shoe_price'], 2) ?></p>
                  <?php else: ?>
                    <p class="regular-price text-xl font-bold text-[#3E2723]">Php <?= number_format((float)$row['shoe_price'], 2) ?></p>
                  <?php endif; ?>

                  <p class="text-sm text-gray-500">Checkouts: <?= (int)$row['shoe_checkouts'] ?></p>
                  <p class="text-sm text-gray-500">Rating: <?= htmlspecialchars($row['shoe_rating']) ?> / 5</p>
                </div>
              </div>
              <?php
            }
          } else {
            echo "<p class='col-span-full text-center text-gray-600'>No products found.</p>";
          }
        ?>
      </div>
    </main>
  </div>

  <?php 
  // Free the result and close connection (do NOT close $stmt here)
  if (isset($result) && $result instanceof mysqli_result) { $result->free(); }
  $conn->close();
  ?>
</body>
</html>
