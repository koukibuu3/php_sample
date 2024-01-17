<?php

declare(strict_types=1);

namespace App\ValueObjects;

use App\Entities\Cell;

/**
 * ビンゴカードの行
 */
final class Line
{
    /** @var Cell[] 行の数字 */
    public readonly array $cells;

    public readonly bool $isBingo;

    public function __construct(array $cells)
    {
        $this->cells = $cells;
    }

    public function isBingo(): bool
    {
        $isBingo = false;
        foreach ($this->cells as $cell) {
            if (!$cell->isHit) {
                $isBingo = false;
                break;
            }
            $isBingo = true;
        }

        return $isBingo;
    }
}
