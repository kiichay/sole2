<?php 
include './db-connect.php';  // Include database connection
include './sidebar.php';  // Include sidebar
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Buyer Notifications</title>
  <link href="./output.css" rel="stylesheet"> <!-- Tailwind CSS -->
  <link href="./styles/buyer-notification.css" rel="stylesheet">
</head>
<body class="flex h-screen">
  <!-- Main content -->
  <main class="main-content flex-1 p-8 overflow-auto">
    <div class="notification-panel mx-auto">
      <!-- Bell -->
      <img src="./img/bell.png" alt="Alerts" class="bell-icon" />

      <!-- Inbox header -->
      <h1 class="inbox-title">Inbox</h1>

      <!-- Today -->
      <section class="mt-6">
        <h2 class="section-title">Today</h2>
        <div class="space-y-4">
          <?php 
            // Example dynamic notifications, fetched from a database
            $notifications_today = [
                "Thank you for your recent purchase! We are happy to inform you that your orders are ready for pick-up.",
                "We regret to inform you that your order for [Product Name] has been canceled due to [reason for cancellation]."
            ];

            foreach ($notifications_today as $notification) {
                echo "<div class='notification-card'>$notification</div>";
            }
          ?>
        </div>
      </section>

      <!-- This Week -->
      <section class="mt-8">
        <h2 class="section-title">This Week</h2>
        <div class="space-y-4">
          <?php 
            // Example dynamic notifications, fetched from a database
            $notifications_week = [
                "We’ve successfully received your payment for the product [Product Name]. Your order is now confirmed!",
                "Great news! Your order for [Product Name] is now ready for pickup."
            ];

            foreach ($notifications_week as $notification) {
                echo "<div class='notification-card'>$notification</div>";
            }
          ?>
        </div>
      </section>
    </div>
  </main>

</body>
</html>
