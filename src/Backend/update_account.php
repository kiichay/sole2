<?php
// /src/Backend/update_account.php
// Make sure uploads dir exists: /src/uploads/avatars (writable)
require __DIR__ . '/../db-connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit('Method Not Allowed');
}

$buyer_id       = $_POST['buyer_id']        ?? '';
$username       = $_POST['username']        ?? '';
$firstname      = $_POST['firstname']       ?? '';
$lastname       = $_POST['lastname']        ?? '';
$address        = $_POST['address']         ?? '';
$contactnumber  = $_POST['contactnumber']   ?? '';
$email          = $_POST['email']           ?? '';
$password       = $_POST['password']        ?? '';
$currentAvatar  = $_POST['current_avatar']  ?? '';

// 1) Get current record (for keeping password/avatar when missing)
$stmt = $conn->prepare("SELECT buyer_password, buyer_profileimage FROM BUYER WHERE buyer_id=? LIMIT 1");
$stmt->bind_param("s", $buyer_id);
$stmt->execute();
$cur = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$cur) { http_response_code(404); exit('Buyer not found'); }

$newPassword = trim($password) !== '' ? $password : $cur['buyer_password']; // keep existing if blank

// 2) Handle avatar upload (optional)
$avatarPathForDB = $cur['buyer_profileimage']; // default keep
if (isset($_FILES['avatar']) && is_uploaded_file($_FILES['avatar']['tmp_name'])) {
  $finfo = new finfo(FILEINFO_MIME_TYPE);
  $mime  = $finfo->file($_FILES['avatar']['tmp_name']);
  $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
  if (isset($allowed[$mime])) {
    $ext = $allowed[$mime];
    $uploadDirFs = __DIR__ . '/../uploads/avatars/';
    if (!is_dir($uploadDirFs)) { @mkdir($uploadDirFs, 0775, true); }
    $filename = 'buyer_'.$buyer_id.'_'.date('Ymd_His').'_'.bin2hex(random_bytes(4)).'.'.$ext;
    $destFs   = $uploadDirFs . $filename;
    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $destFs)) {
      // Path as seen by the browser from /src/ pages
      $avatarPathForDB = './uploads/avatars/' . $filename;
    }
  }
}

// 3) Update DB
$sql = "UPDATE BUYER
        SET buyer_username=?, buyer_firstname=?, buyer_lastname=?, buyer_contactnumber=?,
            buyer_address=?, buyer_email=?, buyer_password=?, buyer_profileimage=?
        WHERE buyer_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param(
  "sssssssss",
  $username, $firstname, $lastname, $contactnumber,
  $address, $email, $newPassword, $avatarPathForDB, $buyer_id
);
$ok = $stmt->execute();
$stmt->close();

// 4) Redirect back (with status)
$back = $_SERVER['HTTP_REFERER'] ?? '../buyer-dashboard.php';
$sep  = (strpos($back, '?') === false) ? '?' : '&';
header("Location: {$back}{$sep}updated=" . ($ok ? '1' : '0'));
exit;
