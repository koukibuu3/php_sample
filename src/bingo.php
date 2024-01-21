<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Entities\Board;

$boards = [];
$boards[] = Board::create('akasaka');
$boards[] = Board::create('yamada');
$boards[] = Board::create('tanaka');

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>ビンゴ</title>
</head>

<body>
  <table>
    <tr>
      <?php foreach ($boards as $board) : ?>
        <th><?= $board->owner ?></th>
      <?php endforeach; ?>
    </tr>
    <tr>
      <?php foreach ($boards as $board) : ?>
        <td>
          <table>
            <?php foreach ($board->lines as $line) : ?>
              <tr>
                <?php foreach ($line->cells as $cell) : ?>
                  <td>
                    <?= $cell->number ?>
                  </td>
                <?php endforeach; ?>
              </tr>
            <?php endforeach; ?>
          </table>
        </td>
      <?php endforeach; ?>
    </tr>
  </table>
</body>
