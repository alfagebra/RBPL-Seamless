<?php
session_start();
include '../koneksi/koneksi.php';

// Ambil data dari form
$user_id  = $_POST['user_id'] ?? '';
$password = $_POST['password'] ?? '';
$role     = $_POST['role'] ?? '';

// Validasi input kosong
if (empty($user_id) || empty($password) || empty($role)) {
    $_SESSION['login_error'] = "Semua field wajib diisi!";
    header("Location: login.php");
    exit;
}

// Query untuk cek user berdasarkan user_id dan role
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ? AND role = ?");
$stmt->bind_param("ss", $user_id, $role);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Verifikasi password
    if (password_verify($password, $user['password'])) {
        // Set session
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['name']    = $user['name'];
        $_SESSION['role']    = $user['role'];

        // Redirect sesuai role
        switch ($user['role']) {
            case 'Buyer':
                header("Location: ../buyer/dashBuyer.php");
                break;
            case 'Marketing Staff':
                header("Location: ../marketing/dashMarketing.php");
                break;
            case 'Warehouse Staff':
                header("Location: ../gudang/dashGudang.php");
                break;
            case 'Expedition Staff':
                header("Location: ../ekspedisi/dashEkspedisi.php");
                break;
            case 'Garment Staff':
                header("Location: ../garment/dashGarment.php");
                break;
            case 'Accounting Staff':
                header("Location: ../akuntansi/dashAkun.php");
                break;
            default:
                $_SESSION['login_error'] = "Role tidak dikenali.";
                header("Location: login.php");
                break;
        }
        exit;
    } else {
        $_SESSION['login_error'] = "ID atau Password salah!";
        header("Location: login.php");
        exit;
    }
} else {
    $_SESSION['login_error'] = "Akun tidak ditemukan!";
    header("Location: login.php");
    exit;
}

$stmt->close();
$conn->close();
?>
