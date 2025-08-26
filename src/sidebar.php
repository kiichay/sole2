  <!-- Include Sidebar -->
  <!--  -->
<link href="./styles/sidebar.css" rel="stylesheet"> 

<aside class="sidebar flex flex-col justify-between text-white">
  <div>
    <!-- Logo -->
    <div class="logo mb-10">
       <img src="./img/logo.png" alt="SoleTech Carcar" class="w-36 mx-auto" /> <!-- Increased width -->
    </div>
    <!-- Nav -->
    <nav class="space-y-6">
      <a href="./buyer-dashboard.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'buyer-dashboard.php') ? 'active' : ''; ?>">
        <img src="./img/home.png" alt="Home" class="icon" /> Home
      </a>
      <a href="./buyer-products.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'buyer-products.php') ? 'active' : ''; ?>">
        <img src="./img/product.png" alt="Products" class="icon" /> Products
      </a>
      <a href="./buyer-checkout.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'buyer-checkout.php') ? 'active' : ''; ?>">
        <img src="./img/cart2.png" alt="Checkout" class="icon" /> Checkout
      </a>
      <a href="#" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'inbox.php') ? 'active' : ''; ?>">
        <img src="./img/inbox.png" alt="Inbox" class="icon" /> Inbox
      </a>
    </nav>
  </div>
  <!-- Logout at bottom -->
  <a href="#" class="nav-link mb-8">
    <img src="./img/logout2.png" alt="Logout" class="icon" /> Logout
  </a>
</aside>
