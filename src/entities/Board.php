<?php

declare(strict_types=1);

namespace App\Entities;

use App\Entities\Cell;
use App\ValueObjects\Line;

/**
 * ビンゴカード
 */
final class Board
{
    /** @var int ビンゴカードの最大数字 */
    private const DEFAULT_MAX_NUMBER = 75;

    /** @var int ビンゴカードの行数 */
    private const DEFAULT_PER_LINE = 5;

    private function __construct(public readonly string $owner, public readonly array $lines)
    {
    }

    /**
     * ビンゴカードを作成する
     */
    public static function create(string $owner): self
    {
        $numbers = range(1, self::DEFAULT_MAX_NUMBER);
        shuffle($numbers);

        $lines = [];
        for ($i = 0; $i < self::DEFAULT_PER_LINE; $i++) {
            $cells = [];
            for ($j = 0; $j < self::DEFAULT_PER_LINE; $j++) {
                $cells[] = new Cell(array_shift($numbers));
            }
            $lines[] = new Line($cells);
        }

        return new self($owner, $lines);
    }

    /**
     * ビンゴカードを再生成する
     *
     * @param string $owner
     * @param Line[] $lines
     */
    public function recreate(string $owner, array $lines): self
    {
        return new self($owner, $lines);
    }

    /**
     * ビンゴの数を計算する
     *
     * @param Line[] $lines
     */
    public function countBingo(): int
    {
        $bingoCount = 0;
        foreach ($this->lines as $line) {
            if ($line->isBingo()) {
                $bingoCount++;
            }
        }

        return $bingoCount;
    }
}
