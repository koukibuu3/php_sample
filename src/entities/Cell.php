<?php

declare(strict_types=1);

namespace App\Entities;

/**
 * ビンゴカードのマス
 */
final class Cell
{
    public function __construct(public readonly int $number, public bool $isHit = false)
    {
    }

    /**
     * 穴を空ける
     */
    public function hit(): self
    {
        $this->isHit = true;
        return $this;
    }
}
