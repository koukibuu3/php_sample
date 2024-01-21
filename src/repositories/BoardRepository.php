<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Board;
use App\Entities\Cell;
use App\ValueObjects\Line;

/**
 * ビンゴカードのリポジトリ
 */
final class BoardRepository
{
    /**
     * ビンゴカードを取得する
     */
    public function findAll(): Board
    {
        $cellValues = [
            'akasaka' => [
                1 => [1, 2, 3, 4, 5],
                2 => [6, 7, 8, 9, 10],
                3 => [11, 12, 13, 14, 15],
                4 => [16, 17, 18, 19, 20],
                5 => [21, 22, 23, 24, 25],
            ],
            'shibuya' => [
                1 => [26, 27, 28, 29, 30],
                2 => [31, 32, 33, 34, 35],
                3 => [36, 37, 38, 39, 40],
                4 => [41, 42, 43, 44, 45],
                5 => [46, 47, 48, 49, 50],
            ],
        ];

        $lines = [];
        foreach ($cellValues as $owner => $lineValues) {
            $cells = [];
            foreach ($lineValues as $lineNumber => $cellValues) {
                foreach ($cellValues as $cellValue) {
                    $cells[] = new Cell($cellValue);
                }
                $lines[] = new Line($cells);
            }
        }
    }
}
