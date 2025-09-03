<?php
include './sidebar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Checkout</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #8b6f47, #a0845c);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Main Content */
        .main-content {
            padding: 40px;
            background: linear-gradient(135deg, #dbc4a1, #c9b084);
            min-height: 100vh;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h2 {
            font-size: 2.5rem;
            color: #4b341e;
            margin-bottom: 10px;
            font-weight: 300;
        }

        .header p {
            color: #6b4423;
            font-size: 1.1rem;
        }

        /* Tab Navigation */
        .tab-nav {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 40px;
        }

        .tab-btn {
            padding: 12px 30px;
            background: rgba(255, 255, 255, 0.2);
            color: #4b341e;
            border: 2px solid transparent;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: 500;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .tab-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .tab-btn.active {
            background: #4b341e;
            color: white;
            border-color: #d4af37;
            box-shadow: 0 8px 25px rgba(75, 52, 30, 0.3);
        }

        /* Product Cards */
        .product-grid {
            display: grid;
            gap: 25px;
            max-width: 800px;
            margin: 0 auto;
        }

        .product-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 25px;
            display: flex;
            align-items: center;
            gap: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .product-image {
            width: 120px;
            height: 120px;
            border-radius: 15px;
            object-fit: cover;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .product-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .product-name {
            font-size: 1.4rem;
            font-weight: 600;
            color: #4b341e;
            margin-bottom: 5px;
        }

        .product-details {
            color: #6b4423;
            font-size: 1rem;
            margin-bottom: 3px;
        }

        .product-quantity {
            color: #8b6f47;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .quantity-badge {
            background: linear-gradient(135deg, #d4af37, #b8941f);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            box-shadow: 0 2px 8px rgba(212, 175, 55, 0.3);
        }

        .quantity-badge.high-quantity {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            animation: pulse 2s infinite;
        }

        .quantity-badge.medium-quantity {
            background: linear-gradient(135deg, #f39c12, #e67e22);
        }

        .total-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: #4b341e;
            margin-left: auto;
            text-align: right;
        }

        .total-price .currency {
            font-size: 0.9rem;
            color: #6b4423;
        }
    </style>
</head>
<body>
    <main class="main-content">
        <div class="header">
            <h2>Your Purchased Products</h2>
        </div>

        <!-- Tab Navigation -->
        <div class="tab-nav">
            <button class="tab-btn active" onclick="filterOrders('pending')">Pending</button>
            <button class="tab-btn" onclick="filterOrders('cancelled')">Cancelled</button>
            <button class="tab-btn" onclick="filterOrders('completed')">Completed</button>
        </div>

        <!-- Product Grid -->
        <div class="product-grid" id="order-list">
            <!-- PENDING ORDERS -->
            <div class="order-section pending-orders">
                <div class="product-card">
                    <img src="https://images.unsplash.com/photo-1608256246200-53e635b5b65f?w=400&h=400&fit=crop" alt="Classic Leather Boots" class="product-image">
                    <div class="product-info">
                        <div class="product-name">Classic Leather Boots</div>
                        <div class="product-details">Premium Collection</div>
                        <div class="product-details">Black Leather - Size 42</div>
                        <div class="product-meta">
                            <span class="quantity-badge">1x</span>
                        </div>
                    </div>
                    <div class="total-price">
                        <span class="currency">₱</span>1,250.00
                    </div>
                </div>

                <div class="product-card">
                    <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400&h=400&fit=crop" alt="Mixed Sports Collection" class="product-image">
                    <div class="product-info">
                        <div class="product-name">Mixed Sports Collection</div>
                        <div class="product-details">Nike, Adidas, Puma</div>
                        <div class="product-details">3 Different Brands & Styles</div>
                        <div class="product-meta">
                            <span class="quantity-badge medium-quantity">3x Mixed</span>
                        </div>
                    </div>
                    <div class="total-price">
                        <span class="currency">₱</span>2,850.00
                    </div>
                </div>
            </div>

            <!-- CANCELLED ORDERS -->
            <div class="order-section cancelled-orders" style="display: none;">
                <div class="product-card">
                    <img src="https://images.unsplash.com/photo-1549298916-b41d501d3772?w=400&h=400&fit=crop" alt="S7 Casual Outdoors" class="product-image">
                    <div class="product-info">
                        <div class="product-name">S7 Casual Outdoors</div>
                        <div class="product-details">CCL Shoes</div>
                        <div class="product-details">Beige, Brown - Size 38, 39</div>
                        <div class="product-meta">
                            <span class="quantity-badge">2x</span>
                        </div>
                    </div>
                    <div class="total-price">
                        <span class="currency">₱</span>900.00
                    </div>
                </div>

                <div class="product-card">
                    <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=400&fit=crop" alt="Sandal Kher Outdoors" class="product-image">
                    <div class="product-info">
                        <div class="product-name">Sandal Kher Outdoors</div>
                        <div class="product-details">CVKG</div>
                        <div class="product-details">White Green - Size 38</div>
                        <div class="product-meta">
                            <span class="quantity-badge">1x</span>
                        </div>
                    </div>
                    <div class="total-price">
                        <span class="currency">₱</span>240.00
                    </div>
                </div>
            </div>

            <!-- COMPLETED ORDERS -->
            <div class="order-section completed-orders" style="display: none;">
                <div class="product-card">
                    <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400&h=400&fit=crop" alt="Premium Running Shoes" class="product-image">
                    <div class="product-info">
                        <div class="product-name">Premium Running Shoes</div>
                        <div class="product-details">Nike Air Max</div>
                        <div class="product-details">Red, Blue - Size 42, 41</div>
                        <div class="product-meta">
                            <span class="quantity-badge">2x</span>
                        </div>
                    </div>
                    <div class="total-price">
                        <span class="currency">₱</span>3,200.00
                    </div>
                </div>

                <div class="product-card">
                    <img src="https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?w=400&h=400&fit=crop" alt="Classic Canvas Sneakers" class="product-image">
                    <div class="product-info">
                        <div class="product-name">Classic Canvas Sneakers</div>
                        <div class="product-details">Converse All Star</div>
                        <div class="product-details">White - Size 40</div>
                        <div class="product-meta">
                            <span class="quantity-badge">1x</span>
                        </div>
                    </div>
                    <div class="total-price">
                        <span class="currency">₱</span>890.00
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Tab filtering functionality
        function filterOrders(status) {
            // Remove active class from all tabs
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Add active class to clicked tab
            event.target.classList.add('active');
            
            // Hide all order sections
            document.querySelectorAll('.order-section').forEach(section => {
                section.style.display = 'none';
            });
            
            // Show the selected status section
            const targetSection = document.querySelector(`.${status}-orders`);
            if (targetSection) {
                targetSection.style.display = 'block';
            }
            
            console.log('Filtering orders by:', status);
        }
    </script>
</body>
</html>
