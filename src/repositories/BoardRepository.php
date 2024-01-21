<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Board;
use App\Entities\Cell;
use App\ValueObjects\Line;
use App\Clients\Mysql;

/**
 * ビンゴカードのリポジトリ
 */
final class BoardRepository
{
    private Mysql $mysql;

    public function __construct()
    {
        $this->mysql = new Mysql();
    }

    /**
     * ビンゴカードを追加する
     */
    public function add(string $owner): void
    {
        $board = Board::create($owner);

        $values = [];
        foreach ($board->lines as $row => $line) {
            foreach ($line->cells as $column => $cell) {
                $isHit = $cell->isHit ? 1 : 0;
                $values[] = "('$owner', $row, $column, {$cell->number}, {$isHit})";
            }
        }

        $this->mysql->query(
            'INSERT INTO Cells (`owner`, `row`, `column`, `value`, `is_hit`) VALUES ' . implode(',', $values)
        );
    }

    /**
     * ビンゴカードをリセットする
     */
    public function reset(): void
    {
        $this->mysql->query('TRUNCATE TABLE Cells');
    }

    /**
     * ビンゴカードを更新する
     */
    public function hit($number): void
    {
        $this->mysql->query(
            "UPDATE Cells SET `is_hit` = true WHERE `value` = {$number}"
        );
    }

    /**
     * ビンゴカードを取得する
     *
     * @return Board[]
     */
    public function findAll(): array
    {
        $cellValues = $this->mysql->query('SELECT * FROM Cells');

        $cells = [];
        foreach ($cellValues as $cellValue) {
            $cells[$cellValue['owner']][$cellValue['row']][$cellValue['column']] = new Cell(
                $cellValue['value'],
                (bool) $cellValue['is_hit']
            );
        }

        $lines = [];
        foreach ($cells as $owner => $rows) {
            foreach ($rows as $row => $columns) {
                $lines[$owner][$row] = new Line($columns);
            }
        }

        $boards = [];
        foreach ($lines as $owner => $lines) {
            $boards[] = Board::recreate($owner, $lines);
        }

        return $boards;
    }
}
