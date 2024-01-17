<?php

declare(strict_types=1);

namespace Tests\Entities;

use App\Entities\Board;
use PHPUnit\Framework\TestCase;

/**
 * @group entities
 * @group Board
 */
final class BoardTest extends TestCase
{
    /**
     * @test
     */
    public function ビンゴカードが作成できる(): void
    {
        $board = Board::create('akasaka');

        $this->assertSame(Board::class, get_class($board));
    }
    /**
     * @test
     */
    public function ビンゴの数が計算できる(): void
    {
        $board = Board::create('akasaka');
        $board->lines[0]->cells[0]->hit();
        $board->lines[0]->cells[1]->hit();
        $board->lines[0]->cells[2]->hit();
        $board->lines[0]->cells[3]->hit();
        $board->lines[0]->cells[4]->hit();

        $this->assertSame(1, $board->countBingo());
    }
}
