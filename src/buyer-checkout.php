<?php 
include './db-connect.php'; 
include './sidebar.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Buyer Checkout</title>
  <link href="./output.css" rel="stylesheet">
  <link href="./styles/buyer-checkout.css" rel="stylesheet">
</head>
<body>
  <!-- Main content -->
  <main class="main-content">
    <div class="page-header">
      <h1 class="page-title">Your Orders</h1>
    </div>

    <!-- Tabs for Order Status -->
    <div class="tabs-container">
      <button class="tab-btn active" id="pending-tab" onclick="filterOrders('pending')">Pending</button>
      <button class="tab-btn" id="cancelled-tab" onclick="filterOrders('cancelled')">Cancelled</button>
      <button class="tab-btn" id="completed-tab" onclick="filterOrders('completed')">Completed</button>
    </div>

    <!-- Orders Container -->
    <div class="orders-container">
      <!-- Pending Orders -->
      <div id="pending-orders" class="order-section active">
        <div class="product-card" onclick="openModal('ORDER001')">
          <div class="product-images">
            <img src="https://images.unsplash.com/photo-1603487742131-4160ec999306?w=100&h=100&fit=crop&crop=center" alt="Sandal 1" class="product-image" />
            <img src="https://images.unsplash.com/photo-1594223274512-ad4803739b7c?w=100&h=100&fit=crop&crop=center" alt="Sandal 2" class="product-image" />
            <img src="https://images.unsplash.com/photo-1520256862855-398228c41684?w=100&h=100&fit=crop&crop=center" alt="Sandal 3" class="product-image" />
            <div class="items-count-badge">4</div>
          </div>
          <div class="product-info">
            <h3 class="order-summary">Order #ORDER001</h3>
            <p class="product-details">Multiple Items - 4 Products</p>
            <p class="total-items">Total: ₱2,890</p>
          </div>
          <div class="status-badge status-pending">Pending</div>
        </div>

        <div class="product-card" onclick="openModal('ORDER002')">
          <div class="product-images">
            <img src="https://images.unsplash.com/photo-1594223274512-ad4803739b7c?w=100&h=100&fit=crop&crop=center" alt="Sandal" class="product-image" />
          </div>
          <div class="product-info">
            <h3 class="order-summary">Sandal Kher Outdoors</h3>
            <p class="product-details">CVXG - White Green - 38</p>
            <p class="total-items">Quantity: 1x</p>
          </div>
          <div class="status-badge status-pending">Pending</div>
        </div>
      </div>

      <!-- Cancelled Orders -->
      <div id="cancelled-orders" class="order-section">
        <div class="product-card" onclick="openModal('ORDER003')">
          <div class="product-images">
            <img src="https://images.unsplash.com/photo-1520256862855-398228c41684?w=100&h=100&fit=crop&crop=center" alt="Summer Sandals" class="product-image" />
          </div>
          <div class="product-info">
            <h3 class="order-summary">Summer Beach Sandals</h3>
            <p class="product-details">BeachWear Pro - Brown - 40</p>
            <p class="total-items">Quantity: 1x</p>
          </div>
          <div class="status-badge status-cancelled">Cancelled</div>
        </div>
      </div>

      <!-- Completed Orders -->
      <div id="completed-orders" class="order-section">
        <div class="product-card" onclick="openModal('ORDER004')">
          <div class="product-images">
            <img src="https://images.unsplash.com/photo-1549298916-b41d501d3772?w=100&h=100&fit=crop&crop=center" alt="Premium Sandals" class="product-image" />
          </div>
          <div class="product-info">
            <h3 class="order-summary">Premium Leather Sandals</h3>
            <p class="product-details">LuxuryWalk - Black - 41</p>
            <p class="total-items">Quantity: 1x</p>
          </div>
          <div class="status-badge status-completed">Completed</div>
        </div>

        <div class="product-card" onclick="openModal('ORDER005')">
          <div class="product-images">
            <img src="https://images.unsplash.com/photo-1515347619252-60a4bf4fff4f?w=100&h=100&fit=crop&crop=center" alt="Sport Sandals" class="product-image" />
          </div>
          <div class="product-info">
            <h3 class="order-summary">Athletic Sport Sandals</h3>
            <p class="product-details">SportMax - Navy - 42</p>
            <p class="total-items">Quantity: 1x</p>
          </div>
          <div class="status-badge status-completed">Completed</div>
        </div>
      </div>
    </div>
  </main>

  <!-- Order Details Modal -->
  <div id="orderModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <h3 id="modal-title" class="modal-title">Order Details</h3>
        <button class="close-btn" onclick="closeModal()">&times;</button>
      </div>
      <div class="modal-body">
        <div id="modal-product-details">
          <!-- Product details will be populated by JavaScript -->
        </div>
      </div>
      <div class="modal-actions" id="modal-actions">
        <!-- Action buttons will be populated by JavaScript -->
      </div>
    </div>
  </div>

  <!-- Rating Modal -->
  <div id="ratingModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Rate Your Order</h3>
        <button class="close-btn" onclick="closeRatingModal()">&times;</button>
      </div>
      <div class="modal-body">
        <div class="rating-container">
          <div class="rating-stars" id="rating-stars">
            <span class="star" data-rating="1">★</span>
            <span class="star" data-rating="2">★</span>
            <span class="star" data-rating="3">★</span>
            <span class="star" data-rating="4">★</span>
            <span class="star" data-rating="5">★</span>
          </div>
          <textarea class="rating-textarea" id="rating-comment" placeholder="Write your thoughts about this product..."></textarea>
        </div>
      </div>
      <div class="modal-actions">
        <button class="btn btn-rate" onclick="submitRating()">Submit Rating</button>
      </div>
    </div>
  </div>

<script src="./scripts/buyer-checkout.js"></script>
</body>
</html>