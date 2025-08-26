<?php 
include './db-connect.php'; 
include './Backend/dashboard.php'; 
include './sidebar.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Buyer Dashboard</title>
  <link href="./output.css" rel="stylesheet">
  <link href="./styles/buyer-dashboard.css" rel="stylesheet">
</head>
<body class="flex h-screen bg-[#dbc4a1]">

  <!-- Sidebar -->

  <div class="flex-1 flex flex-col ml-1/5">
    
    <!-- Navbar -->
     <?php include './navbar.php' ?>

    <!-- Main content for the products -->
    <main class="main-content flex-grow p-8">

      <!-- Best Selling Products Section -->
      <div class="section-title text-2xl font-bold mb-2">Best Selling Products</div>
      <div class="text-sm text-gray-200 mt-2 mb-4">Recommended Products</div>

      <div class="product-list grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
        <?php if ($bestSellingResult->num_rows > 0): ?>
          <?php while($row = $bestSellingResult->fetch_assoc()): ?>
            <div class="product-item bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300 ease-in-out relative">

              <!-- Sale Banner: Display only if the product is on sale -->
              <?php if (isset($row['shoe_sale_price']) && $row['shoe_sale_price'] < $row['shoe_price'] && !empty($row['shoe_sale_price'])): ?>
                <div class="sale-banner absolute top-0 left-0 bg-red-500 text-white px-2 py-1 text-xs font-bold uppercase">Sale</div>
              <?php endif; ?>

              <!-- Product Image -->
              <img src="<?php echo $row['shoe_image']; ?>" alt="<?php echo $row['shoe_name']; ?>" class="w-full h-48 object-cover" />

              <div class="product-info p-4">
                <!-- Product Name -->
                <h3 class="text-lg font-semibold text-[#3E2723]"><?php echo $row['shoe_name']; ?></h3>

                <!-- Check if the product is on sale -->
                <?php if (isset($row['shoe_sale_price']) && $row['shoe_sale_price'] < $row['shoe_price'] && !empty($row['shoe_sale_price'])): ?>
                  <!-- Display Sale Price First (Bold and Large) -->
                  <p class="text-xl font-bold text-[#b08968]">Php <?php echo number_format($row['shoe_sale_price'], 2); ?></p>
                  <!-- Display Regular Price (Strikethrough) -->
                  <p class="text-base font-semibold line-through text-gray-500">Php <?php echo number_format($row['shoe_price'], 2); ?></p>
                <?php else: ?>
                  <!-- Display Regular Price if not on sale -->
                  <p class="text-base font-bold text-[#3E2723]">Php <?php echo number_format($row['shoe_price'], 2); ?></p>
                <?php endif; ?>

                <!-- Number of Checkouts -->
                <p class="text-sm text-gray-500">Checkouts: <?php echo $row['shoe_checkouts']; ?></p>

                <!-- Product Rating -->
                <p class="text-sm text-gray-500">Ratings: <?php echo $row['shoe_rating']; ?> / 5</p>
              </div>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <p class="text-center text-gray-500">No best-selling products available</p>
        <?php endif; ?>
      </div>

      <!-- Latest Products (Top Picks) Section -->
      <div class="section-title text-2xl font-bold mb-2">Latest Products</div>
      <div class="text-sm text-gray-200 mt-2 mb-4">Top picks</div>

      <div class="product-list grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
        <?php if ($latestProductsResult->num_rows > 0): ?>
          <?php while($row = $latestProductsResult->fetch_assoc()): ?>
            <div class="product-item bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300 ease-in-out relative">

              <!-- Sale Banner: Display only if the product is on sale -->
              <?php if (isset($row['shoe_sale_price']) && $row['shoe_sale_price'] < $row['shoe_price'] && !empty($row['shoe_sale_price'])): ?>
                <div class="sale-banner absolute top-0 left-0 bg-red-500 text-white px-2 py-1 text-xs font-bold uppercase">Sale</div>
              <?php endif; ?>

              <!-- Product Image -->
              <img src="<?php echo $row['shoe_image']; ?>" alt="<?php echo $row['shoe_name']; ?>" class="w-full h-48 object-cover" />

              <div class="product-info p-4">
                <!-- Product Name -->
                <h3 class="text-lg font-semibold text-[#3E2723]"><?php echo $row['shoe_name']; ?></h3>

                <!-- Check if the product is on sale -->
                <?php if (isset($row['shoe_sale_price']) && $row['shoe_sale_price'] < $row['shoe_price'] && !empty($row['shoe_sale_price'])): ?>
                  <!-- Display Sale Price First (Bold and Large) -->
                  <p class="text-xl font-bold text-[#b08968]">Php <?php echo number_format($row['shoe_sale_price'], 2); ?></p>
                  <!-- Display Regular Price (Strikethrough) -->
                  <p class="text-base font-semibold line-through text-gray-500">Php <?php echo number_format($row['shoe_price'], 2); ?></p>
                <?php else: ?>
                  <!-- Display Regular Price if not on sale -->
                  <p class="text-base font-bold text-[#3E2723]">Php <?php echo number_format($row['shoe_price'], 2); ?></p>
                <?php endif; ?>

                <!-- Number of Checkouts -->
                <p class="text-sm text-gray-500">Checkouts: <?php echo $row['shoe_checkouts']; ?></p>

                <!-- Product Rating -->
                <p class="text-sm text-gray-500">Rating: <?php echo $row['shoe_rating']; ?> / 5</p>
              </div>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <p class="text-center text-gray-500">No latest products available</p>
        <?php endif; ?>
      </div>
    </main>
  </div>

  <script src="./scripts/buyer-dashboard.js"></script>
</body>
</html>

<?php $conn->close(); ?>

