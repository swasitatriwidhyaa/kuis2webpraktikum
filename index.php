<?php
session_start();
include 'connection.php';


if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $photo = null;


    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $photo = 'uploads/' . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo);
    }

    $query = "INSERT INTO users (username, password, photo) VALUES ('$username', '$password', '$photo')";
    if (mysqli_query($conn, $query)) {
        echo "User berhasil didaftarkan.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">

        <h3>Daftar Akun Baru</h3>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Upload Foto Profil</label>
                <input type="file" name="photo" id="photo" class="form-control">
            </div>
            <button type="submit" name="register" class="btn btn-primary">Daftar</button>
        </form>

        <h3 class="mt-5">Daftar Akun</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['username'] ?></td>
                    <td><img src="<?= $row['photo'] ?>" width="50"></td>
                    <td>
                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Hapus</a>
                        <a href="login.php?username=<?= $row['username'] ?>" class="btn btn-success btn-sm">Login</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>
</body>
</html>
