<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// $host = getenv('MYSQLHOST');
// $db   = getenv('MYSQLDATABASE');
// $user = getenv('MYSQLUSER');
// $pass = getenv('MYSQLPASSWORD');
// $port = getenv('MYSQLPORT') ?: 3306;

// try {
//    $pdo = new PDO(
//         "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4",
//         $user,
//         $pass
//     );

//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//     $sql = file_get_contents(__DIR__ . '/sistem_bkk.sql');

//     if (!$sql) {
//         die("sistem_bkk.sql tidak ditemukan");
//     }

//     $pdo->exec($sql);

//     echo "Import database berhasil!";
// } catch (PDOException $e) {
//     die("Error: " . $e->getMessage());
// }
