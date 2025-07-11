<?php
include '../koneksi/koneksi.php'; // pastikan file koneksi benar

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $name     = htmlspecialchars(trim($_POST['name']));
    $company  = htmlspecialchars(trim($_POST['company']));
    $email    = htmlspecialchars(trim($_POST['email']));
    $role     = htmlspecialchars(trim($_POST['role']));
    $user_id  = htmlspecialchars(trim($_POST['user_id']));
    $password = $_POST['password'];

    // Validasi: semua field wajib kecuali company
    if (empty($name) || empty($email) || empty($role) || empty($user_id) || empty($password)) {
        echo "Please fill in all required fields.";
        exit;
    }

    // Cek apakah user_id sudah terpakai
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE user_id = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "User ID already taken.";
        exit;
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Simpan ke database
    $stmt = $conn->prepare("INSERT INTO users (name, company, email, role, user_id, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $company, $email, $role, $user_id, $hashed_password);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful! Please login.'); window.location.href = 'login.php';</script>";
    } else {
        echo "Registration failed. Please try again.";
    }
}
?>
