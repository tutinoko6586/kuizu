<?php
$file = 'board.txt';

// 既存データ取得
$board = [];
if (file_exists($file)) {
    $board = json_decode(file_get_contents($file), true);
    if (!is_array($board)) $board = [];
}

// メッセージがPOSTされていれば追加
if (!empty($_POST['message'])) {
    $message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');
    $board[] = $message;
    file_put_contents($file, json_encode($board, JSON_UNESCAPED_UNICODE));
}

// 出力
foreach ($board as $msg) {
    echo '<p>', $msg, '</p><hr>';
}
?>
