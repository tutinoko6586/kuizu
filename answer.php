<?php
// データベース接続情報
$dsn = 'mysql:host=localhost;dbname=wine_quiz;charset=utf8';
$username = 'root';  // ユーザー名
$password = '';      // パスワード（XAMPPなどでは空のことが多い）

try {
    // PDOでデータベース接続
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  // エラーモードを例外に設定
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
} catch (PDOException $e) {
    die("データベース接続エラー: " . $e->getMessage());
}

// フォームが送信された場合
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ユーザーの回答と正解の比較
    $user_answers = [];
    $correct_answers = [
        "question1" => "9月〜10月",
        "question2" => "ラベルが相手に見えるようにする",
        "question3" => "ボトルの底を持つ",
        "question4" => "ワインを注ぎ終える際にボトルの口を軽く回しながら持ち上げる",
        "question5" => "赤ワインはグラスの1/3程度（約120ml）",
        "question6" => "スワリングは香りを引き出すため",
        "question7" => "ステムを持つ",
        "question8" => "ステム（脚の部分）を持つ",
        "question9" => "マリアージュはワインと料理の相性のこと",
        "question10" => "ワインのテイスティングは視覚・嗅覚・味覚で行う"
    ];
    
    $score = 0;
    foreach ($correct_answers as $key => $correct) {
        $user_answers[$key] = isset($_POST[$key]) ? htmlspecialchars($_POST[$key]) : "";
        if ($user_answers[$key] === $correct) {
            $score++;
        }
    }

    $percentage = ($score / 10) * 100;

    // データベースに保存
    $stmt = $pdo->prepare("INSERT INTO wine_quiz_answers (id,question1, question2, question3, question4, question5, question6, question7, question8, question9, question10, score) 
                           VALUES (NULL,:q1, :q2, :q3, :q4, :q5, :q6, :q7, :q8, :q9, :q10, :score)");
    $stmt->execute([
        ':q1' => $user_answers["question1"],
        ':q2' => $user_answers["question2"],
        ':q3' => $user_answers["question3"],
        ':q4' => $user_answers["question4"],
        ':q5' => $user_answers["question5"],
        ':q6' => $user_answers["question6"],
        ':q7' => $user_answers["question7"],
        ':q8' => $user_answers["question8"],
        ':q9' => $user_answers["question9"],
        ':q10' => $user_answers["question10"],
        ':score' => $score
    ]);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>クイズ結果</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        table { width: 60%; margin: 20px auto; border-collapse: collapse; }
        th, td { padding: 15px; border: 1px solid #ddd; }
        th { background-color: #f2f2f2; }
        .correct { color: blue; }
        .incorrect { color: red; }
    </style>
</head>
<body>
    <h1>クイズ結果</h1>
    <h2>スコア: <?= $percentage ?>点</h2>

    <table>
        <tr>
            <th>問題</th>
            <th>あなたの回答</th>
            <th>正解</th>
            <th>結果</th>
        </tr>
        <?php foreach ($correct_answers as $key => $correct) { 
            $num = substr($key, -1);  // question1 → 1 に変換
            $user_answer = $user_answers[$key];
            $is_correct = ($user_answer === $correct);
        ?>
        <tr>
            <td><?= $num ?>問目</td>
            <td><?= $user_answer ?: "未回答" ?></td>
            <td><?= $correct ?></td>
            <td class="<?= $is_correct ? 'correct' : 'incorrect' ?>">
                <?= $is_correct ? "正解！" : "不正解" ?>
            </td>
        </tr>
        <?php } ?>
    </table>

    <br>
    <button onclick="window.history.back();">戻る</button>
</body>
</html>
