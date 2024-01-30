<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Repositories\BoardRepository;
use App\Repositories\NumberRepository;
use App\Services\BoardService;

// フレームワークを利用する際は別途コントローラーに切り出す
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $boardService = new BoardService(new BoardRepository(), new NumberRepository());

  match ($_POST['stage']) {
    'reset' => $boardService->reset(),
    'add' => $boardService->init(array_map(fn ($owner) => trim($owner), explode(',', $_POST['owners']))),
    'roll' => $boardService->roll(),
  };
  // 画面リロードでPOSTが再送信されないようGETにリダイレクト
  header('Location: /src/views/bingo.php');
}

// フレームワークを利用する際は別途コントローラーに切り出す
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $boards = (new BoardRepository())->findAll();
}

// var_dump($boards);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>ビンゴ | php_sample</title>
  <link rel="stylesheet" href="./bingo.css">
</head>

<body>
  <h1>ビンゴ</h1>

  <div class="button-container">
    <?php if (!empty($boards)) : ?>
      <form action="bingo.php" method="post">
        <input type="hidden" name="stage" value="reset">
        <input type="submit" value="ビンゴカードをリセット">
      </form>
      <form action="bingo.php" method="post">
        <input type="hidden" name="stage" value="roll">
        <input type="submit" value="ビンゴを回す">
      </form>
    <?php else : ?>
      <form action="bingo.php" method="post">
        <input type="hidden" name="stage" value="add">
        <input type="text" name="owners" placeholder="名前をカンマ区切りで入力してください" size="50">
        <input type="submit" value="メンバー決定">
      </form>
    <?php endif; ?>
  </div>

  <div class="bingo-card-container">
    <?php foreach ($boards as $board) : ?>
      <div class="bingo-card">
        <h2><?= $board->owner ?></h2>
        <table>
          <?php foreach ($board->lines as $line) : ?>
            <tr>
              <?php foreach ($line->cells as $cell) : ?>
                <?php if ($cell->isHit) : ?>
                  <td class="bingo-card-hit"><?= $cell->number ?></td>
                <?php else : ?>
                  <td><?= $cell->number ?></td>
                <?php endif; ?>
              <?php endforeach; ?>
            </tr>
          <?php endforeach; ?>
        </table>
        <ul>
          <li>ビンゴ数： <?= $board->countBingo() ?></li>
          <li>リーチ数： <?= $board->countReach() ?></li>
        </ul>
      </div>
    <?php endforeach; ?>
  </div>
</body>
