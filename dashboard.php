<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

include 'connection.php';

$username = $_SESSION['user'];
$query = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    $user = [
        'username' => $username,
        'photo' => 'default-profile.png'
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-custom {
            background-color: #212529;
        }
        .profile-img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
            margin-right: 10px;
        }
        .welcome-box {
            background-color: #d1e7dd;
            border-left: 5px solid #0f5132;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            color: #0f5132;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom px-4">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- Kiri: Foto Profil & Username -->
        <div class="d-flex align-items-center text-white">
            <img src="<?php echo $user['photo'] ? $user['photo'] : 'default-profile.png'; ?>" class="profile-img" alt="Foto Profil">
            <span><?php echo htmlspecialchars($user['username']); ?></span>
        </div>
        
        <!-- Kanan: Tombol Logout -->
        <div>
            <a href="logout.php" class="btn btn-outline-light">Logout</a>
        </div>
    </div>
</nav>

<!-- Isi Dashboard -->
<div class="container mt-5">
    <div class="welcome-box">
        <h5><strong>Selamat Datang, <?php echo htmlspecialchars($user['username']); ?>!</strong></h5>
        <p>Kamu berhasil login ke dalam sistem. Ini adalah halaman dashboard sederhana.</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
