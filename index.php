<?php 

$title1 = 'ワイン用のぶどうの収穫時期はいつでしょうか？';
$title2 = 'ワインを注ぐとき、ラベルはどの向きにするのがマナーでしょうか';
$title3 = 'ワインを注ぐとき、ボトルはどのように持つのが正しいでしょうか';
$title4 = 'ワインを注ぐときに、注ぎ終わりにこぼれない工夫として正しいのはどれでしょう';
$title5 = 'ワインをグラスに注ぐときの適量の目安として正しいのはどれでしょう';
$title6 = 'ワインを注いだ後、グラスを回す（スワリング）目的として正しいのはどれでしょう';
$title7 = 'ワイングラスの構造は、上から リム・ボウル・〇〇〇・プレート となっています。 〇〇〇に当てはまる正しい名称はどれでしょう';
$title8 = 'ワイングラスの正しい持ち方はどれでしょう';
$title9 = 'ワインと食事のバランスが良いことを表すワイン用語はどれでしょう';
$title10 = 'ワインのテイスティングには3つのステップがあります。1つ目は「香り」、2つ目は「味」、では3つ目は何でしょう';

$question1 = array('3月〜5月', '6月〜8月', '9月〜11月', '12月〜2月');
$question2 = array('ラベルを自分に向ける','ラベルを相手に向ける','ラベルを上に向ける','ラベルを下に向ける');
$question3 = array('ボトルの首を持つ', 'ボトルの底を持つ', 'ボトルのラベル部分を持つ', 'ボトルのキャップ部分を持つ');
$question4 = array('注ぎ終わる直前にボトルを軽く振る', 'ボトルの口を回しながら静かに持ち上げる ', '一気にボトルを持ち上げる', 'グラスのふちにボトルを軽く当てる');
$question5 = array('グラスの満杯まで注ぐ','グラスの1/2程度（約150ml）','グラスの1/3程度（約120ml）','グラスの1/10程度（約30ml）');
$question6 = array('ワインを早く温めるため', 'ワインを空気に触れさせ、香りを引き出すため', 'ワインの色を変えるため', 'グラスを美しく見せるため');
$question7 = array('ステム', 'ベース', 'フット', 'シャフト');
$question8 = array(' ボウル部分をしっかり握る','ステム（脚の部分）を持つ','プレート（底の部分）を指でつまむ','グラスのリム（飲み口）を持つ');
$question9 = array('アロマ', ' テロワール', 'マリアージュ', ' ボディ');
$question10 = array('色（視覚）', '温度', '産地', '歴史');

$answer1 = $question1[2];
$answer2 = $question2[1];
$answer3 = $question3[1];
$answer4 = $question4[1];
$answer5 = $question5[1];
$answer6 = $question6[1];
$answer7 = $question7[0];
$answer8 = $question8[1];
$answer9 = $question9[2];
$answer10 = $question10[0];

shuffle($question1);
shuffle($question2);
shuffle($question3);
shuffle($question4);
shuffle($question5);
shuffle($question6);
shuffle($question7);
shuffle($question8);
shuffle($question9);
shuffle($question10);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="refresh" content="300;url=answer.php">
    <title>ワインクイズ</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            text-align: center;
            background: #f9f5f0;
            margin: 0;
            padding: 20px;
        }

        /* タイマーと時計の配置 */
        .timer-container {
            position: fixed;
            right: 20px;
            top: 20px;
            text-align: center;
        }

        #clockCanvas {
            display: block;
            margin: 0 auto;
        }

        #timer {
            font-size: 18px;
            color: #eb6ea5;
            font-weight: bold;
        }

        .quiz-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #8B0000; /* ワインレッド */
        }
        h2 {
            color: #b33e5c;
            margin-top: 20px;
            font-size: 16px;
            text-align: justify;
        }
        .radio-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin: 10px 0;
        }
        .radio-container label {
            display: inline-block;
            width: 40%;
            padding: 12px;
            border: 2px solid #ccc;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
            background: white;
            text-align: center;
        }

        .radio-container input {
            display: none;
        }

        .radio-container label:hover {
            background-color: #e0e0e0;
        }

        .radio-container input:checked + label {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        /* 送信ボタン */
        .submit-btn {
            margin-top: 20px;
            padding: 12px 24px;
            font-size: 18px;
            color: white;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            transition: 0.3s;
            background: linear-gradient(135deg, #8B0000, #6a5acd);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            width: 30%;
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, #6a5acd, #8B0000);
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>

<div class="quiz-container">
    <h1>ワインクイズ</h1>
    <div class="timer-container">
    <h2>残り時間: <span id="timer">300秒</span></h2>
    <canvas id="clockCanvas" width="100" height="100"></canvas>
</div>
    <form method="post" action="answer.php">
        
        <h2><?php echo $title1; ?></h2>
        <div class="radio-container">
            <?php foreach($question1 as $value) { ?>
                <input type="radio" id="q1_<?php echo $value; ?>" name="question1" value="<?php echo $value; ?>">
                <label for="q1_<?php echo $value; ?>"><?php echo $value; ?></label>
            <?php } ?>
            <input type="radio" name="question1" value="" checked="checked" style="display:none;">
        </div>
        <input type="hidden" name="answer1" value="<?php echo $answer1; ?>">

        <h2><?php echo $title2; ?></h2>
        <div class="radio-container">
            <?php foreach($question2 as $value) { ?>
                <input type="radio" id="q2_<?php echo $value; ?>" name="question2" value="<?php echo $value; ?>">
                <label for="q2_<?php echo $value; ?>"><?php echo $value; ?></label>
            <?php } ?>
            <input type="radio" name="question2" value="" checked="checked" style="display:none;">
        </div>
        <input type="hidden" name="answer2" value="<?php echo $answer2; ?>">

        <h2><?php echo $title3; ?></h2>
        <div class="radio-container">
            <?php foreach($question3 as $value) { ?>
                <input type="radio" id="q3_<?php echo $value; ?>" name="question3" value="<?php echo $value; ?>">
                <label for="q3_<?php echo $value; ?>"><?php echo $value; ?></label>
            <?php } ?>
            <input type="radio" name="question3" value="" checked="checked" style="display:none;">
        </div>
        <input type="hidden" name="answer3" value="<?php echo $answer3; ?>">
        <h2><?php echo $title4; ?></h2>
        <div class="radio-container">
            <?php foreach($question4 as $value) { ?>
                <input type="radio" id="q4_<?php echo $value; ?>" name="question4" value="<?php echo $value; ?>">
                <label for="q4_<?php echo $value; ?>"><?php echo $value; ?></label>
            <?php } ?>
            <input type="radio" name="question4" value="" checked="checked" style="display:none;">
        </div>
        <input type="hidden" name="answer4" value="<?php echo $answer4; ?>">

        <h2><?php echo $title5; ?></h2>
        <div class="radio-container">
            <?php foreach($question5 as $value) { ?>
                <input type="radio" id="q5_<?php echo $value; ?>" name="question5" value="<?php echo $value; ?>">
                <label for="q5_<?php echo $value; ?>"><?php echo $value; ?></label>
            <?php } ?>
            <input type="radio" name="question5" value="" checked="checked" style="display:none;">
        </div>
        <input type="hidden" name="answer5" value="<?php echo $answer5; ?>">

        <h2><?php echo $title6; ?></h2>
        <div class="radio-container">
            <?php foreach($question6 as $value) { ?>
                <input type="radio" id="q6_<?php echo $value; ?>" name="question6" value="<?php echo $value; ?>">
                <label for="q6_<?php echo $value; ?>"><?php echo $value; ?></label>
            <?php } ?>
            <input type="radio" name="question6" value="" checked="checked" style="display:none;">
        </div>
        <input type="hidden" name="answer6" value="<?php echo $answer6; ?>">
        <h2><?php echo $title7; ?></h2>
        <div class="radio-container">
            <?php foreach($question7 as $value) { ?>
                <input type="radio" id="q7_<?php echo $value; ?>" name="question7" value="<?php echo $value; ?>">
                <label for="q7_<?php echo $value; ?>"><?php echo $value; ?></label>
            <?php } ?>
            <input type="radio" name="question7" value="" checked="checked" style="display:none;">
        </div>
        <input type="hidden" name="answer7" value="<?php echo $answer7; ?>">

        <h2><?php echo $title8; ?></h2>
        <div class="radio-container">
            <?php foreach($question8 as $value) { ?>
                <input type="radio" id="q8_<?php echo $value; ?>" name="question8" value="<?php echo $value; ?>">
                <label for="q8_<?php echo $value; ?>"><?php echo $value; ?></label>
            <?php } ?>
            <input type="radio" name="question8" value="" checked="checked" style="display:none;">
        </div>
        <input type="hidden" name="answer8" value="<?php echo $answer8; ?>">

        <h2><?php echo $title9; ?></h2>
        <div class="radio-container">
            <?php foreach($question9 as $value) { ?>
                <input type="radio" id="q9_<?php echo $value; ?>" name="question9" value="<?php echo $value; ?>">
                <label for="q9_<?php echo $value; ?>"><?php echo $value; ?></label>
            <?php } ?>
            <input type="radio" name="question9" value="" checked="checked" style="display:none;">
        </div>
        <input type="hidden" name="answer9" value="<?php echo $answer9; ?>">
        <h2><?php echo $title10; ?></h2>
        <div class="radio-container">
            <?php foreach($question10 as $value) { ?>
                <input type="radio" id="q10_<?php echo $value; ?>" name="question10" value="<?php echo $value; ?>">
                <label for="q10_<?php echo $value; ?>"><?php echo $value; ?></label>
            <?php } ?>
            <input type="radio" name="question10" value="" checked="checked" style="display:none;">
        </div>
        <input type="hidden" name="answer10" value="<?php echo $answer10; ?>">
        <!-- quiz-container内のform開始タグの直後あたりに追加 -->
        <h2>ペンネームを入力してください</h2>
        <input type="text" name="pen_name" required style="width: 80%; padding: 10px; font-size: 16px;">
        <br>
        <button type="submit" class="submit-btn">送信</button>
        <p class="log"></p>
    </form>
</div>
<script>
    let timer = 300; // 300秒 = 5分

    function drawClock() {
        const canvas = document.getElementById("clockCanvas");
        const ctx = canvas.getContext("2d");
        const centerX = canvas.width / 2;
        const centerY = canvas.height / 2;
        const radius = 40;

        ctx.clearRect(0, 0, canvas.width, canvas.height);

        ctx.beginPath();
        ctx.arc(centerX, centerY, radius, 0, 2 * Math.PI);
        ctx.stroke();

        const minutes = Math.floor(timer / 60);
        const seconds = timer % 60;

        const secondAngle = (seconds * 6) * Math.PI / 180 - Math.PI / 2;
        const minuteAngle = (minutes * 6 + seconds * 0.1) * Math.PI / 180 - Math.PI / 2;

        drawHand(secondAngle, radius * 0.9, 1);
        drawHand(minuteAngle, radius * 0.8, 3);

        requestAnimationFrame(drawClock);
    }

    function drawHand(angle, length, width) {
        const canvas = document.getElementById("clockCanvas");
        const ctx = canvas.getContext("2d");
        const centerX = canvas.width / 2;
        const centerY = canvas.height / 2;

        ctx.beginPath();
        ctx.lineWidth = width;
        ctx.moveTo(centerX, centerY);
        ctx.lineTo(centerX + length * Math.cos(angle), centerY + length * Math.sin(angle));
        ctx.stroke();
    }

    function updateTimer() {
    setInterval(() => {
        let minutes = Math.floor(timer / 60);
        let seconds = (timer % 60).toString().padStart(2, '0');
        document.getElementById("timer").innerText = `${minutes}:${seconds}`;
        
        if (timer <= 0) {
            clearInterval();
            document.forms[0].submit();
        }
        timer--;
    }, 1000);
}
function confirmSubmit() {
        return confirm("回答を送信しますか？");
    }

    window.onload = function () {
        localStorage.clear(); // 戻った時にリセット
    };
    document.querySelector(".submit-btn").addEventListener("click", confirmSubmit);
    updateTimer(); 
    drawClock(); 
</script>
</body>
</html>
