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
    public const DEFAULT_MAX_NUMBER = 75;

    /** @var int ビンゴカードの行数 */
    public const DEFAULT_PER_LINE = 5;

    /** @var Line[] ビンゴ判定用の行・列・斜め */
    private array $linesForJudge = [];

    private function __construct(public readonly string $owner, public readonly array $lines)
    {
        // 横のビンゴ判定用の行を作成する
        $this->linesForJudge = $lines;

        // 縦のビンゴ判定用の行を作成する
        for ($i = 0; $i < count($lines); $i++) {
            $this->linesForJudge = array_merge(
                $this->linesForJudge,
                [new Line(array_map(fn ($line) => $line->cells[$i], $lines))]
            );
        }

        // 斜めのビンゴ判定用の行を作成する
        $this->linesForJudge = array_merge(
            $this->linesForJudge,
            [new Line(array_map(fn ($key) => $lines[$key]->cells[$key], array_keys($lines)))]
        );
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
     * ビンゴの数を計算する
     *
     * @param Line[] $lines
     */
    public function countBingo(): int
    {
        $bingoCount = 0;
        foreach ($this->linesForJudge as $line) {
            if ($line->isBingo()) {
                $bingoCount++;
            }
        }

        return $bingoCount;
    }

    /**
     * リーチの数を計算する
     */
    public function countReach(): int
    {
        $reachCount = 0;
        foreach ($this->linesForJudge as $line) {
            if ($line->isReach()) {
                $reachCount++;
            }
        }

        return $reachCount;
    }
}
