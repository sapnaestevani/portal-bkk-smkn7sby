<?php
// ============================================================================
// FILE: logout.php - DESTROY SESSION & REDIRECT KE LOGIN PUBLIK
// ============================================================================

// 1. Start session (wajib untuk bisa destroy)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Hapus semua variabel session
$_SESSION = array();

// 3. Hapus cookie session jika ada
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), 
        '', 
        time() - 42000,  // Expired
        $params["path"], 
        $params["domain"], 
        $params["secure"], 
        $params["httponly"]
    );
}

// 4. Destroy session
session_destroy();

// 5. ✅ REDIRECT KE HALAMAN LOGIN PUBLIK
// Dari: C:\xampp\htdocs\bkk\SistemBKK_smkn7\logout.php
// Ke:   C:\xampp\htdocs\bkk\index.php
// Path: ../index.php (naik 1 level)
header("Location: ../index.php");
exit;
?>