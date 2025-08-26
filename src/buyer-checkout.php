<?php 
include './db-connect.php';  // Include database connection
include './sidebar.php';  // Include sidebar
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Buyer Checkout</title>
  <link href="./output.css" rel="stylesheet"> <!-- your Tailwind build -->
  <link href="./styles/buyer-checkout.css" rel="stylesheet">
</head>
<body class="flex h-screen">

<!-- Main content -->
  <main class="main-content flex-1 p-8 overflow-auto">
    <div class="text-center mb-6">
      <h2 class="text-3xl font-bold text-[#4b341e]">Your Purchased Products</h2>
    </div>

    <!-- Tabs for Order Status -->
    <div class="flex justify-center space-x-10 mb-6">
      <button class="tab-btn active" id="pending" onclick="filterOrders('pending')">Pending</button>
      <button class="tab-btn" id="cancelled" onclick="filterOrders('cancelled')">Cancelled</button>
      <button class="tab-btn" id="completed" onclick="filterOrders('completed')">Completed</button>
    </div>

    <!-- Product Cards -->
    <div id="order-list" class="space-y-6">
      <?php 
      // Fetch product orders from database
      $sql = "SELECT * FROM orders WHERE status = 'pending'";  // Example query for pending orders
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          // Loop through each product
          while($row = $result->fetch_assoc()) {
              echo "
              <div class='product-card' onclick='openModal(\"{$row['product_name']}\")'>
                <img src='./images/{$row['image']}' alt='{$row['product_name']}' class='product-img' />
                <div class='product-info'>
                  <h3 class='product-name text-lg font-semibold'>{$row['product_name']}</h3>
                  <p class='product-details text-sm text-gray-600'>{$row['color']} - {$row['size']}</p>
                  <p class='product-quantity text-sm text-gray-500'>Quantity: {$row['quantity']}</p>
                </div>
              </div>
              ";
          }
      } else {
          echo "<p>No pending orders.</p>";
      }
      ?>
    </div>
  </main>

  <!-- Checkout Modal -->
  <div id="checkoutModal" class="modal hidden">
    <div class="modal-content">
      <div class="flex justify-between items-center">
        <h3 id="modal-title" class="modal-title text-lg font-semibold">Product Details</h3>
        <button onclick="closeModal()" class="close-btn text-xl">&times;</button>
      </div>
      <div class="product-details">
        <p><strong>Pickup date:</strong> 04-29-2025</p>
        <p><strong>Order ID:</strong> 250AWFEDSF24</p>
        <p><strong>Order Subtotal:</strong> ₱890</p>
        <p><strong>Total Payment:</strong> ₱890</p>
      </div>
      <!-- Cancel Button -->
      <button class="submit-btn bg-red-500 text-white p-3 mt-4 rounded-md" onclick="cancelOrder()">Cancel</button>
    </div>
  </div>

  <script src="./scripts/pending.js"></script> <!-- External JavaScript -->
</body>
</html>

<?php 
$conn->close();  // Close the database connection
?>
