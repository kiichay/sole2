// This is temporary script for buyer checkout page functionality

let currentOrderId = null;
    let currentRating = 0;
    let currentOrderData = {};

    // Enhanced order data with multiple items
    const ordersData = {
      'ORDER001': {
        pickupDate: '04-29-2025',
        orderId: 'ORDER001',
        subtotal: '₱2,790',
        shippingFee: '₱100',
        total: '₱2,890',
        status: 'pending',
        items: [
          {
            name: 'S7 Casual Outdoors Sandal',
            brand: 'CCLShade',
            details: 'Beige - 39',
            quantity: 2,
            price: '₱890',
            image: 'https://images.unsplash.com/photo-1603487742131-4160ec999306?w=100&h=100&fit=crop&crop=center'
          },
          {
            name: 'Sandal Kher Outdoors',
            brand: 'CVXG',
            details: 'White Green - 38',
            quantity: 1,
            price: '₱750',
            image: 'https://images.unsplash.com/photo-1594223274512-ad4803739b7c?w=100&h=100&fit=crop&crop=center'
          },
          {
            name: 'Summer Beach Sandals',
            brand: 'BeachWear Pro',
            details: 'Brown - 40',
            quantity: 1,
            price: '₱650',
            image: 'https://images.unsplash.com/photo-1520256862855-398228c41684?w=100&h=100&fit=crop&crop=center'
          },
          {
            name: 'Sport Sneakers',
            brand: 'SportMax',
            details: 'Navy - 41',
            quantity: 1,
            price: '₱500',
            image: 'https://images.unsplash.com/photo-1515347619252-60a4bf4fff4f?w=100&h=100&fit=crop&crop=center'
          }
        ]
      },
      'ORDER002': {
        pickupDate: '05-02-2025',
        orderId: 'ORDER002',
        subtotal: '₱750',
        total: '₱750',
        status: 'pending',
        items: [
          {
            name: 'Sandal Kher Outdoors',
            brand: 'CVXG',
            details: 'White Green - 38',
            quantity: 1,
            price: '₱750',
            image: 'https://images.unsplash.com/photo-1594223274512-ad4803739b7c?w=100&h=100&fit=crop&crop=center'
          }
        ]
      },
      'ORDER003': {
        pickupDate: '04-20-2025',
        orderId: 'ORDER003',
        subtotal: '₱650',
        total: '₱650',
        status: 'cancelled',
        items: [
          {
            name: 'Summer Beach Sandals',
            brand: 'BeachWear Pro',
            details: 'Brown - 40',
            quantity: 1,
            price: '₱650',
            image: 'https://images.unsplash.com/photo-1520256862855-398228c41684?w=100&h=100&fit=crop&crop=center'
          }
        ]
      },
      'ORDER004': {
        pickupDate: '03-15-2025',
        orderId: 'ORDER004',
        subtotal: '₱1,200',
        total: '₱1,200',
        status: 'completed',
        items: [
          {
            name: 'Premium Leather Sandals',
            brand: 'LuxuryWalk',
            details: 'Black - 41',
            quantity: 1,
            price: '₱1,200',
            image: 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=100&h=100&fit=crop&crop=center'
          }
        ]
      },
      'ORDER005': {
        pickupDate: '03-10-2025',
        orderId: 'ORDER005',
        subtotal: '₱950',
        total: '₱950',
        status: 'completed',
        items: [
          {
            name: 'Athletic Sport Sandals',
            brand: 'SportMax',
            details: 'Navy - 42',
            quantity: 1,
            price: '₱950',
            image: 'https://images.unsplash.com/photo-1515347619252-60a4bf4fff4f?w=100&h=100&fit=crop&crop=center'
          }
        ]
      }
    };

    // Tab filtering function
    function filterOrders(status) {
      // Hide all order sections
      document.querySelectorAll('.order-section').forEach(section => {
        section.classList.remove('active');
      });
      
      // Show selected order section
      document.getElementById(status + '-orders').classList.add('active');
      
      // Update tab active state
      document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
      });
      document.getElementById(status + '-tab').classList.add('active');
    }

    // Open order details modal
    function openModal(orderId) {
      currentOrderId = orderId;
      const orderData = ordersData[orderId];
      
      if (!orderData) {
        console.error('Order not found:', orderId);
        return;
      }

      const modalTitle = document.getElementById('modal-title');
      const modalDetails = document.getElementById('modal-product-details');
      const modalActions = document.getElementById('modal-actions');
      
      modalTitle.textContent = `Order ${orderData.orderId}`;
      
      let modalContent = '';
      
      // If order has 3 or more items, show individual products
      if (orderData.items.length >= 3) {
        modalContent = '<div class="products-list">';
        orderData.items.forEach(item => {
          modalContent += `
            <div class="product-item">
              <img src="${item.image}" alt="${item.name}" class="product-item-image" />
              <div class="product-item-info">
                <div class="product-item-name">${item.name}</div>
                <div class="product-item-details">${item.brand}</div>
                <div class="product-item-details">${item.details}</div>
                <div class="product-item-quantity">Qty: ${item.quantity}x</div>
              </div>
              <div class="product-item-price">${item.price}</div>
            </div>
          `;
        });
        modalContent += '</div>';
      } else {
        // For orders with less than 3 items, show simple list
        modalContent = '<div class="products-list">';
        orderData.items.forEach(item => {
          modalContent += `
            <div class="product-item">
              <img src="${item.image}" alt="${item.name}" class="product-item-image" />
              <div class="product-item-info">
                <div class="product-item-name">${item.name}</div>
                <div class="product-item-details">${item.brand}</div>
                <div class="product-item-details">${item.details}</div>
                <div class="product-item-quantity">Qty: ${item.quantity}x</div>
              </div>
              <div class="product-item-price">${item.price}</div>
            </div>
          `;
        });
        modalContent += '</div>';
      }
      
      // Add order summary
      modalContent += `
        <div class="order-summary-section">
          <div class="product-detail-item">
            <span class="detail-label">Pickup Date:</span>
            <span class="detail-value">${orderData.pickupDate}</span>
          </div>
          <div class="product-detail-item">
            <span class="detail-label">Order ID:</span>
            <span class="detail-value">${orderData.orderId}</span>
          </div>
          <div class="product-detail-item">
            <span class="detail-label">Order Subtotal:</span>
            <span class="detail-value">${orderData.subtotal}</span>
          </div>
          ${orderData.shippingFee ? `
          <div class="product-detail-item">
            <span class="detail-label">Shipping Fee:</span>
            <span class="detail-value">${orderData.shippingFee}</span>
          </div>` : ''}
          <div class="product-detail-item">
            <span class="detail-label">Total Payment:</span>
            <span class="detail-value">${orderData.total}</span>
          </div>
        </div>
      `;
      
      modalDetails.innerHTML = modalContent;
      
      // Set action buttons based on status
      if (orderData.status === 'pending') {
        modalActions.innerHTML = '<button class="btn btn-cancel" onclick="cancelOrder()">Cancel Order</button>';
      } else if (orderData.status === 'completed') {
        modalActions.innerHTML = `
          <button class="btn btn-rate" onclick="openRatingModal()">Rate</button>
          <button class="btn btn-reorder" onclick="reorderProduct()">Reorder</button>
        `;
      } else if (orderData.status === 'cancelled') {
        modalActions.innerHTML = '<button class="btn btn-reorder" onclick="reorderProduct()">Reorder</button>';
      }
      
      document.getElementById('orderModal').classList.add('show');
      document.body.style.overflow = 'hidden';
    }

    // Close order details modal
    function closeModal() {
      document.getElementById('orderModal').classList.remove('show');
      document.body.style.overflow = 'auto';
    }

    // Open rating modal
    function openRatingModal() {
      closeModal();
      document.getElementById('ratingModal').classList.add('show');
      
      // Reset rating
      currentRating = 0;
      document.querySelectorAll('.star').forEach(star => {
        star.classList.remove('active');
      });
      document.getElementById('rating-comment').value = '';
    }

    // Close rating modal
    function closeRatingModal() {
      document.getElementById('ratingModal').classList.remove('show');
      document.body.style.overflow = 'auto';
    }

    // Handle star rating
    document.querySelectorAll('.star').forEach(star => {
      star.addEventListener('click', function() {
        currentRating = parseInt(this.dataset.rating);
        
        // Update star display
        document.querySelectorAll('.star').forEach((s, index) => {
          if (index < currentRating) {
            s.classList.add('active');
          } else {
            s.classList.remove('active');
          }
        });
      });
    });

    // Submit rating
    function submitRating() {
      const comment = document.getElementById('rating-comment').value;
      
      if (currentRating === 0) {
        alert('Please select a rating');
        return;
      }
      
      // Here you would send the rating to your backend
      console.log('Rating:', currentRating, 'Comment:', comment, 'Order ID:', currentOrderId);
      
      alert('Thank you for your rating!');
      closeRatingModal();
    }

    // Cancel order function
    function cancelOrder() {
      if (confirm('Are you sure you want to cancel this order?')) {
        // Here you would send the cancellation request to your backend
        console.log('Cancelling order:', currentOrderId);
        alert('Order has been cancelled');
        closeModal();
        // You can update the UI here to move the order to cancelled section
      }
    }

    // Reorder function
    function reorderProduct() {
      // Here you would handle reordering logic
      console.log('Reordering:', currentOrderId);
      alert('Products added to cart!');
      closeModal();
    }

    // Close modal when clicking outside
    document.querySelectorAll('.modal').forEach(modal => {
      modal.addEventListener('click', function(e) {
        if (e.target === this) {
          this.classList.remove('show');
          document.body.style.overflow = 'auto';
        }
      });
    });

    // Initialize page
    document.addEventListener('DOMContentLoaded', function() {
      // Show pending orders by default
      filterOrders('pending');
    });