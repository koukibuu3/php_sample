<?php

declare(strict_types=1);

namespace Tests\Entities;

use App\Entities\Cell;
use PHPUnit\Framework\TestCase;

/**
 * @group entities
 * @group Cell
 */
final class CellTest extends TestCase
{
    /**
     * @test
     */
    public function 穴を空けられる(): void
    {
        $cell = new Cell(1);
        $this->assertFalse($cell->isHit);

        $cell->hit();
        $this->assertTrue($cell->isHit);
    }
}
