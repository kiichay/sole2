<?php
// navbar.php
require __DIR__ . '/db-connect.php'; // expects $conn = new mysqli(...)

// TEMP buyer for testing (you can replace with $_SESSION later)
$buyer_id = 'BY000001';

// Fetch buyer
$sql = "SELECT buyer_id, buyer_username, buyer_firstname, buyer_lastname, buyer_contactnumber,
               buyer_address, buyer_profileimage, buyer_email
        FROM BUYER WHERE buyer_id = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $buyer_id);
$stmt->execute();
$res = $stmt->get_result();
$buyer = $res->fetch_assoc();
$stmt->close();

// Fallbacks if something's missing (kept minimal)
function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
$imgPath  = !empty($buyer['buyer_profileimage']) ? $buyer['buyer_profileimage'] : './img/profile.png';
$handle   = !empty($buyer['buyer_username']) ? '@'.$buyer['buyer_username'] : '@user';
$phone    = !empty($buyer['buyer_contactnumber']) ? $buyer['buyer_contactnumber'] : '';
$fullName = trim(($buyer['buyer_firstname'] ?? '').' '.($buyer['buyer_lastname'] ?? ''));
$email    = $buyer['buyer_email'] ?? '';
$address  = $buyer['buyer_address'] ?? '';
?>

<link rel="stylesheet" href="./styles/navbar.css">

<header class="navbar">
  <div class="left-section">
    <a href="./buyer-notification.php" class="notification-icon" title="Notifications">
      <img src="./img/bell.png" alt="Notifications">
    </a>

    <form action="<?php echo e($_SERVER['PHP_SELF']); ?>" method="GET" class="search-form" id="searchForm">
      <input
        type="text"
        id="searchInput"
        name="search"
        placeholder="Search"
        class="search-input"
      />
      <input type="hidden" name="from" value="search_page">
    </form>
  </div>

  <div class="right-section">
    <img src="./img/carrt.png" alt="Cart" class="cart-icon" id="cartIcon">
    <img src="<?php echo e($imgPath); ?>" alt="Profile" class="profile-icon" id="profileIcon">
  </div>
</header>

<!-- ============ Account Settings Modal ============ -->
<div id="profileModal" class="modal" aria-hidden="true">
  <div class="modal-content settings-card">
    <button class="close" id="closeProfileModal" aria-label="Close">×</button>

    <div class="modal-header"><h2>Account Settings</h2></div>

    <div class="modal-body">
      <!-- Left -->
      <div class="profile-info">
        <img id="profileImg" src="<?php echo e($imgPath); ?>" alt="Profile photo" class="avatar">
        <div class="handle"><?php echo e($handle); ?></div>
        <?php if($phone): ?><div class="phone"><?php echo e($phone); ?></div><?php endif; ?>
      </div>

      <div class="line-divider"></div>

      <!-- Right -->
      <div class="account-details">
        <p><strong>Full Name:</strong> <?php echo e($fullName ?: '—'); ?></p>
        <p class="email-line"><strong>Email Address:</strong> <?php echo e($email ?: '—'); ?></p>
      </div>
    </div>

    <div class="modal-footer">
      <button class="btn" id="editAccountBtn">Edit Account</button>
    </div>
  </div>
</div>

<!-- ============ Edit Account Modal (with avatar preview) ============ -->
<div id="editAccountModal" class="modal" aria-hidden="true">
  <div class="modal-content edit-card">
    <button class="close" id="closeEditModal" aria-label="Close">×</button>

    <div class="edit-avatar-wrap">
      <img id="avatarPreview" src="<?php echo e($imgPath); ?>" alt="Avatar" class="profile-avatar">
      <button type="button" class="change-avatar-btn" id="changeAvatarBtn">Change Avatar</button>

      <!-- Hidden file input; belongs to the form below -->
      <input type="file" id="avatarInput" name="avatar" accept="image/*" class="file-input-hidden" form="editAccountForm">
    </div>

    <h2 class="edit-title">Edit Account</h2>

    <form action="./Backend/update_account.php" method="POST" id="editAccountForm" enctype="multipart/form-data">
      <input type="hidden" name="buyer_id" value="<?php echo e($buyer['buyer_id']); ?>">
      <input type="hidden" name="current_avatar" value="<?php echo e($imgPath); ?>">

      <div class="form-field">
        <label for="username">Username</label>
        <input id="username" name="username" type="text" required value="<?php echo e($buyer['buyer_username']); ?>">
      </div>

      <div class="form-row">
        <div class="form-field">
          <label for="firstname">First Name</label>
          <input id="firstname" name="firstname" type="text" required value="<?php echo e($buyer['buyer_firstname']); ?>">
        </div>
        <div class="form-field">
          <label for="lastname">Last Name</label>
          <input id="lastname" name="lastname" type="text" required value="<?php echo e($buyer['buyer_lastname']); ?>">
        </div>
      </div>

      <div class="form-field">
        <label for="address">Address</label>
        <input id="address" name="address" type="text" required value="<?php echo e($address); ?>">
      </div>

      <div class="form-row">
        <div class="form-field">
          <label for="contactnumber">Contact Number</label>
          <input id="contactnumber" name="contactnumber" type="text" required value="<?php echo e($phone); ?>">
        </div>
        <div class="form-field">
          <label for="email">Email</label>
          <input id="email" name="email" type="email" required value="<?php echo e($email); ?>">
        </div>
      </div>

      <div class="form-field">
        <label for="password">Password <span class="muted">(leave blank to keep current)</span></label>
        <input id="password" name="password" type="password" placeholder="************">
      </div>

      <div class="form-actions">
        <button type="button" class="btn btn-secondary" id="backFromEditBtn">Back</button>
        <button type="submit" class="btn">Update Account</button>
      </div>
    </form>
  </div>
</div>

<!-- Alert Banner (Initially hidden) -->
<div id="alertBanner" class="alert-banner" style="display: none;">
    <span id="alertMessage"></span> 
    <!-- <button onclick="closeAlert()">×</button> -->
</div>



<script src="./scripts/navbar.js"></script>
