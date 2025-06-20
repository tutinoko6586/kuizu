<?php
// ユーザーの答えと正しい答えを受け取る
$correct_answers = [];
$explanations = [
    "question1" => "ここに1問目の解説が入ります。",
    "question2" => "2問目の解説が入ります。",
    "question3" => "3問目の解説が入ります。",
    "question4" => "ワインを注ぎ終える際にボトルの口を軽く回しながら持ち上げることで、液だれを防ぐことができます。一気に持ち上げたり、振ったりするとこぼれる原因になります。",
    "question5" => "赤ワインは香りを楽しむため、グラスの 1/3程度（約120ml） に注ぐのが一般的。<br>白ワインは冷やして飲むため、 1/2程度（約150ml） まで注いでもOK。スパークリングワインは泡を楽しむため 2/3程度 が目安。<br>満杯まで注ぐ（A） と香りを楽しめず、こぼれやすくなるのでNG。<br>少なすぎる（D） とワインの味わいや香りを十分に楽しめない。<br>適量を守って、美味しくワインを楽しみましょう！",
    "question6" => "スワリング（グラスを回すこと）は、ワインを空気に触れさせることで 香りを引き出し、味わいをまろやかにする 効果があります。<br>特に赤ワインは空気と触れ合わせることで、より豊かな香りや味わいを楽しめます。<br>A（温めるため） や C（色を変えるため） は誤りで、D（グラスを美しく見せるため） も目的ではありません。ワインを美味しく味わうために、適度にスワリングしてみましょう！",
    "question7" => "ワイングラスの各部分の名称は以下の通りです：リム（Rim）：グラスの飲み口部分<br>ボウル（Bowl）：ワインを入れる部分<br>ステム（Stem）：持ち手となる細い脚の部分<br>プレート（Plate）（または ベース（Base））：グラスの底の部分<br>ステムを持つことで、ワインの温度が手の熱で変わるのを防ぐ ことができます。正しい持ち方を意識して、美味しくワインを楽しみましょう！",
    "question8" => "ワイングラスは ステム（脚の部分）を持つ のが正しい持ち方です。<br>手の熱がワインに伝わるのを防ぎ、適温を保つため<br>ボウルに指紋がつかず、美しい見た目を維持できるため<br>スワリング（ワインを回す動作）がしやすくなるため<br>A（ボウルを握る） → 手の熱でワインの温度が変わるためNG<br>C（プレートをつまむ） → 安定しにくく、倒れるリスクがある<br>D（リムを持つ） → 口をつける部分なので衛生的でない<br>美味しくワインを楽しむために、ステムを持つ習慣をつけましょう！",
    "question9" => "「マリアージュ（Mariage）」はフランス語で「結婚」を意味し、ワインと料理の相性が良いことを表す言葉です。料理とワインが互いに引き立て合うことで、より美味しく楽しめます。<br>A. アロマ → ワインの香りを指<br>B. テロワール → ぶどうの産地の土壌や気候などの特徴を表す<br>D. ボディ → ワインのコクや重さを表す<br>食事に合ったワインを選んで、美味しいマリアージュを楽しみましょう！",
    "question10" => "ワインのテイスティングは 「視覚・嗅覚・味覚」 の3つの要素で行います。<br>色（視覚） 🍷👀 → ワインの色や透明度を見て、熟成度や品種の特徴を確認<br>香り（嗅覚） 🍇👃 → スワリングして香りを楽しみ、フルーティーさやスパイシーさを感じる<br>味（味覚） 🍷👅 → 口に含んで酸味・甘み・渋み・余韻を確かめる<br>B（温度） はテイスティングの要素ではなく、ワインの飲み頃の話。<br>C（産地） や D（歴史） もワインの知識として重要ですが、テイスティングの基本3要素ではありません。<br>ワインを味わうときは、「見る・香る・味わう」の3ステップを意識しましょう！"
];
for ($i = 1; $i <= 10; $i++) {
    $correct_answers["question$i"] = isset($_POST["answer$i"]) ? $_POST["answer$i"] : "";
}
// ユーザーの解答（未選択なら空文字を代入）
$user_answers = [];
for ($i = 1; $i <= 10; $i++) {
    $user_answers["question$i"] = isset($_POST["question$i"]) ? $_POST["question$i"] : "";
}
// 得点を計算
$score = 0;
foreach ($user_answers as $question => $answer) {
    if ($answer !== "" && $answer === $correct_answers[$question]) {
        $score++;
    }
}
$score = ($score / 10) * 100;

// 結果を判定
function check_answer($user_answer, $correct_answer) {
    if ($user_answer === "") {
        return "未回答（不正解）"; // 選択していない場合は「未回答（不正解）」と表示
    }
    return ($user_answer === $correct_answer) ? "正解！" : "不正解";
}
// 結果のリスト作成
$results = [];
$colors = [];
for ($i = 1; $i <= 10; $i++) {
    $questionKey = "question$i";
    $results[$i] = check_answer($user_answers[$questionKey], $correct_answers[$questionKey]);
    $colors[$i] = ($results[$i] === "正解！") ? 'blue' : 'red';
}
require 'score.php';
// POSTからペンネームとスコアを取得
$pen_name = isset($_POST['pen_name']) ? trim($_POST['pen_name']) : '';
// データベースに保存
$stmt = $pdo->prepare("INSERT INTO quiz_scores (pen_name, score, created_at) VALUES (?, ?, NOW())");
$stmt->execute([$pen_name, $score]);
// 直近5件の履歴取得
$history_stmt = $pdo->query("SELECT pen_name, score, created_at FROM quiz_scores ORDER BY id DESC LIMIT 5");
$score_history = array_reverse($history_stmt->fetchAll(PDO::FETCH_ASSOC));
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>クイズ結果</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        table {
            width: 70%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        td {
            text-align: center;
        }
        .alert-button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            text-align: center;
            display: inline-block;
            margin: auto;
            margin-top: 5px;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .alert-button:hover {
            background-color: #45a049;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
        }
        .alert-button:active {
            background-color: #388e3c;
            transform: translateY(1px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        /* モーダルのスタイル */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 50%;
            text-align: left;
            line-height: 1.6;
            font-size: 16px;
        }
        .close-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
            display: flex;
            justify-content: center;  /* 横方向中央揃え */
            align-items: center;      /* 縦方向中央揃え */
            margin: auto;
            margin-top: 20px;
            width: 30%;
        }
        .close-btn:hover {
            background-color: #45a049;
        }
        .time-date{
            text-align: left;
            margin: 0 0 10px;
        }
        #board{
            width: 70%;
            margin: 10% auto 2%;
        }
        .time-date:nth-child(2) {
            margin : 0;
            padding: 0;
        }
        .en-gurahu{
            width: 50%;
            text-align: center;
            margin: auto;
        }
        #lineChart{
            display: block;
            box-sizing: border-box;
            height: auto !important;
            width: 100% !important;
        }
        #scoreChart {
            width: 100%;
        }
        .result{
            margin-bottom: 10%;
        }
        .alert-button{
            margin: 10% 0;
        }
        .oresen-grahu{
            width: 70%;
            margin: 10% auto 10%;
        }
        body {
            margin: 0;
            padding: 0;
            background-color: pink; /* 外側をピンクに */
            font-family: sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 40px auto; /* 上下40px, 左右中央 */
            background-color: white; /* 中央白 */
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* 少し影で浮かせる */
        }
        .fade-in-down {
            opacity: 0;
            transform: translateY(50px);
            transition: all 1s ease-out;
            will-change: opacity, transform;
        }
        .fade-in-down.visible {
            opacity: 1;
            transform: translateY(0);
        }
        @keyframes slideInLeft {
            0% {
                opacity: 0;
                transform: translateX(-100px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }
       .slide-in-left {
            animation: slideInLeft 1s ease-out forwards;
        }
        @media screen and (max-width: 767px) {
            table {
                width: 90%;
                margin: 20px auto;
                border-collapse: collapse;
            }
            .alert-button {
                font-size: 14px;
            }
            h2{
                font-size: 20px;
            }
            .oresen-grahu {
                width: 100%;
                margin: auto;
            }
        }
    </style>
    <script>
        // モーダルを表示する関数
        function showExplanation(questionNumber) {
            const explanations = {
                "1": "ここに1問目の解説が入ります。",
                "2": "2問目の解説が入ります。",
                "3": "3問目の解説が入ります。",
                "4": "ワインを注ぎ終える際にボトルの口を軽く回しながら持ち上げることで、液だれを防ぐことができます。一気に持ち上げたり、振ったりするとこぼれる原因になります。",
                "5": "赤ワインは香りを楽しむため、グラスの 1/3程度（約120ml） に注ぐのが一般的。<br>白ワインは冷やして飲むため、 1/2程度（約150ml） まで注いでもOK。スパークリングワインは泡を楽しむため 2/3程度 が目安。<br>満杯まで注ぐ（A） と香りを楽しめず、こぼれやすくなるのでNG。<br>少なすぎる（D） とワインの味わいや香りを十分に楽しめない。<br>適量を守って、美味しくワインを楽しみましょう！",
                "6": "スワリング（グラスを回すこと）は、ワインを空気に触れさせることで 香りを引き出し、味わいをまろやかにする 効果があります。<br>特に赤ワインは空気と触れ合わせることで、より豊かな香りや味わいを楽しめます。<br>A（温めるため） や C（色を変えるため） は誤りで、D（グラスを美しく見せるため） も目的ではありません。ワインを美味しく味わうために、適度にスワリングしてみましょう！",
                "7": "ワイングラスの各部分の名称は以下の通りです：リム（Rim）：グラスの飲み口部分<br>ボウル（Bowl）：ワインを入れる部分<br>ステム（Stem）：持ち手となる細い脚の部分<br>プレート（Plate）（または ベース（Base））：グラスの底の部分<br>ステムを持つことで、ワインの温度が手の熱で変わるのを防ぐ ことができます。正しい持ち方を意識して、美味しくワインを楽しみましょう！",
                "8": "ワイングラスは ステム（脚の部分）を持つ のが正しい持ち方です。<br>手の熱がワインに伝わるのを防ぎ、適温を保つため<br>ボウルに指紋がつかず、美しい見た目を維持できるため<br>スワリング（ワインを回す動作）がしやすくなるため<br>A（ボウルを握る） → 手の熱でワインの温度が変わるためNG<br>C（プレートをつまむ） → 安定しにくく、倒れるリスクがある<br>D（リムを持つ） → 口をつける部分なので衛生的でない<br>美味しくワインを楽しむために、ステムを持つ習慣をつけましょう！",
                "9": "「マリアージュ（Mariage）」はフランス語で「結婚」を意味し、ワインと料理の相性が良いことを表す言葉です。料理とワインが互いに引き立て合うことで、より美味しく楽しめます。<br>A. アロマ → ワインの香りを指<br>B. テロワール → ぶどうの産地の土壌や気候などの特徴を表す<br>D. ボディ → ワインのコクや重さを表す<br>食事に合ったワインを選んで、美味しいマリアージュを楽しみましょう！",
                "10": "ワインのテイスティングは 「視覚・嗅覚・味覚」 の3つの要素で行います。<br>色（視覚） 🍷👀 → ワインの色や透明度を見て、熟成度や品種の特徴を確認<br>香り（嗅覚） 🍇👃 → スワリングして香りを楽しみ、フルーティーさやスパイシーさを感じる<br>味（味覚） 🍷👅 → 口に含んで酸味・甘み・渋み・余韻を確かめる<br>B（温度） はテイスティングの要素ではなく、ワインの飲み頃の話。<br>C（産地） や D（歴史） もワインの知識として重要ですが、テイスティングの基本3要素ではありません。<br>ワインを味わうときは、「見る・香る・味わう」の3ステップを意識しましょう！"
            };
            // モーダルを表示
            const modal = document.getElementById("explanationModal");
            const modalContent = document.getElementById("modalContent");
            modalContent.innerHTML = explanations[questionNumber] + "<br><button class='close-btn' onclick='closeModal()'>OK</button>";
            modal.style.display = "flex";
        }
        // モーダルを閉じる関数
        function closeModal() {
            const modal = document.getElementById("explanationModal");
            modal.style.display = "none";
        }
    </script>
</head>
<body>
    <div class="container">
    <div class="result">
        <div class="score">
            <h1 class="slide-in-left">クイズ結果</h1>
            <table class="table fade-in-down">
                <tr>
                    <th>問題</th>
                    <th>結果</th>
                    <th>解説</th>
                </tr>
                <?php for ($i = 1; $i <= 10; $i++) { ?>
                <tr>
                    <td><?php echo $i; ?>問目</td>
                    <td><span style="color: <?php echo $colors[$i]; ?>"><?php echo $results[$i]; ?></span></td>
                    <td>
                        <button class="alert-button" onclick="showExplanation('<?php echo $i; ?>')">解説を見る</button>
                    </td>
                </tr>
                <?php } ?>
                <tr>
                    <th>得点</th>
                    <td colspan="2"><?php echo $score; ?> 点</td>
                </tr>
                <tr>
                    <th>評価</th>
                        <td colspan="2">    
                            <p style="text-align: center;">
                                <?php
                                    if ($score == 100) {
                                        echo "全問正解！素晴らしい！";
                                    }elseif ($score >= 80) {
                                        echo "素晴らしい";
                                    } elseif ($score >= 60) {
                                        echo "良い結果";
                                    } elseif ($score >= 40) {
                                        echo "もう少し頑張りましょう。";
                                    } elseif ($score >= 10) {
                                        echo "頑張りましょう";
                                    } else {
                                        echo "頑張ってください！";
                                    }
                                ?>
                            </p>
                        </td>
                    </th>
                </tr>
                <tr>
                    <td colspan="3">
                        <div class="en-gurahu">
                            <h2 class="slide-in-left">スコア円グラフ</h2>
                            <canvas id="scoreChart"  class="table fade-in-down" width="200" height="200"></canvas>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <?php
        echo "<h2 class='slide-in-left'>スコア履歴（最新5件）</h2>";
        echo "<table class='table fade-in-down' border='1' style='margin:auto;'>";
        echo "<tr><th>日時</th><th>名前</th><th>スコア</th></tr>";
        foreach ($score_history as $row) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['pen_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['score']) . " 点</td>";
            echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    ?>
    <button onclick="exportToCSV()" class="alert-button fade-in-down">スコア履歴をExcel出力</button>
        <div class="oresen-grahu table fade-in-down">
            <h2 class="slide-in-left">最新5件折れ線グラフ</h2>
            <canvas id="lineChart" width="400" height="200"></canvas>
        </div>
    <!-- モーダル -->
    <div id="explanationModal" class="modal fade-in-down">
        <div class="modal-content" id="modalContent"></div>
    </div>
    <p>投稿するメッセージを入力してください</p>
    <form id="postForm">
        <input type="text" name="message" id="message" required>
        <input type="submit" value="投稿">
    </form>
    <div id="board"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = <?php echo json_encode(array_map(fn($row) => $row['pen_name'], $score_history)); ?>;
        const data = <?php echo json_encode(array_map(fn($row) => $row['score'], $score_history)); ?>;
        const ctx = document.getElementById('lineChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'スコア推移（名前ごと）',
                    data: data,
                    borderColor: '#FF6384',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderWidth: 2,
                    tension: 0.3,
                    pointRadius: 5
                }]
            },
            options: {
                scales: {
                    y: {
                        suggestedMin: 0,
                        suggestedMax: 100,
                        title: { display: true, text: '得点' }
                    },
                    x: {
                        title: { display: true, text: 'ペンネーム' }
                    }
                }
            }
        });
    </script>
    <script>
        // 投稿処理
        document.getElementById('postForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch('board-output.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.text())
            .then(html => {
                document.getElementById('board').innerHTML = html;
                document.getElementById('message').value = '';
            });
        });
        // 初回読み込み
        window.addEventListener('load', () => {
            fetch('board-output.php')
            .then(res => res.text())
            .then(html => {
                document.getElementById('board').innerHTML = html;
            });
        });
    </script>
    <script>
        window.addEventListener('load', () => {
            const canvas = document.getElementById('scoreChart');
            const ctx = canvas.getContext('2d');
            const score = <?php echo $score; ?>;
            const incorrect = 100 - score;
            const centerX = canvas.width / 2;
            const centerY = canvas.height / 2;
            const radius = 80;
            // スコアの割合（角度）
            const correctAngle = (score / 100) * 2 * Math.PI;
            // 背景（不正解部分）
            ctx.beginPath();
            ctx.fillStyle = '#f08080'; // 赤系（不正解）
            ctx.moveTo(centerX, centerY);
            ctx.arc(centerX, centerY, radius, 0, 2 * Math.PI);
            ctx.closePath();
            ctx.fill();
            // スコア部分
            ctx.beginPath();
            ctx.fillStyle = '#4CAF50'; // 緑（正解）
            ctx.moveTo(centerX, centerY);
            ctx.arc(centerX, centerY, radius, -0.5 * Math.PI, correctAngle - 0.5 * Math.PI);
            ctx.closePath();
            ctx.fill();
            // 真ん中にスコアを描画
            ctx.fillStyle = "#000";
            ctx.font = "20px Arial";
            ctx.textAlign = "center";
            ctx.textBaseline = "middle";
            ctx.fillText(score + "%", centerX, centerY);
        });
    </script>
<script>
    function exportToCSV() {
        const rows = [["名前", "スコア", "日時"]];
        <?php foreach ($score_history as $row): ?>
            rows.push([
                "<?php echo htmlspecialchars($row['pen_name']); ?>",
                "<?php echo htmlspecialchars($row['score']); ?>",
                "<?php echo htmlspecialchars($row['created_at']); ?>"
            ]);
        <?php endforeach; ?>
        // CSV形式に変換（Excelで文字化けしないようにBOM付き）
        const csvContent = "\uFEFF" + rows.map(e => e.join(",")).join("\n");
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        // ダウンロードリンク生成してクリック
        const link = document.createElement("a");
        link.href = URL.createObjectURL(blob);
        link.download = "score_history.csv";
        document.body.appendChild(link); // Firefox対応のため一時追加
        link.click();
        document.body.removeChild(link);
    }
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const targets = document.querySelectorAll('.fade-in-down');

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry, index) => {
      if (entry.isIntersecting) {
        // 順番に遅延させて表示
        setTimeout(() => {
          entry.target.classList.add('visible');
        }, index * 300); // 0.3秒ずつ遅延
        observer.unobserve(entry.target); // 一度だけ
      }
    });
  }, {
    threshold: 0.2
  });

  targets.forEach(el => observer.observe(el));
});
</script>
</body>
</html>
