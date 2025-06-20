<?php
$dsn = 'mysql:host=localhost;dbname=kuizu_db;charset=utf8';
$user = 'kuizu_user';
$password = 'kuizu_pass';

try {
    $pdo = new PDO($dsn, $user, $password);
    // ここに echo "DB接続成功！"; を入れている場合
} catch (PDOException $e) {
    exit('DB接続エラー: ' . $e->getMessage());
}
?>
