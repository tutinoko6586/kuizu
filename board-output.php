<?php
require 'db.php';
date_default_timezone_set('Asia/Tokyo');

// 投稿処理
if (!empty($_POST['message'])) {
    $message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');
    $datetime = date('Y-m-d H:i:s');

    $stmt = $pdo->prepare('INSERT INTO board (message, datetime) VALUES (?, ?)');
    $stmt->execute([$message, $datetime]);
}

// 出力
$stmt = $pdo->query('SELECT * FROM board ORDER BY id DESC');
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($posts as $post) {
    $datetime = htmlspecialchars($post['datetime'], ENT_QUOTES, 'UTF-8');
    $message  = htmlspecialchars($post['message'], ENT_QUOTES, 'UTF-8');

    echo '<p class="time-date">' . $datetime . '</p>';
    echo '<p class="time-date">' . $message . '</p><hr>';
}
?>
