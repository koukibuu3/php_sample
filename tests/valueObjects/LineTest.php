<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use App\Entities\Cell;
use App\ValueObjects\Line;
use PHPUnit\Framework\TestCase;

/**
 * @group valueObjects
 * @group Line
 */
final class LineTest extends TestCase
{
    /**
     * @test
     */
    public function ビンゴになっているか(): void
    {
        $line = new Line([
            new Cell(1, true),
            new Cell(2, true),
            new Cell(3, true),
            new Cell(4, true),
            new Cell(5, true),
        ]);
        $this->assertTrue($line->isBingo());

        $line = new Line([
            new Cell(1, true),
            new Cell(2, true),
            new Cell(3, true),
            new Cell(4, true),
            new Cell(5, false),
        ]);
        $this->assertFalse($line->isBingo());
    }

    /**
     * @test
     */
    public function リーチになっているか(): void
    {
        $line = new Line([
            new Cell(1, true),
            new Cell(2, true),
            new Cell(3, true),
            new Cell(4, false),
            new Cell(5, false),
        ]);
        $this->assertFalse($line->isReach());

        $line = new Line([
            new Cell(1, true),
            new Cell(2, true),
            new Cell(3, true),
            new Cell(4, true),
            new Cell(5, false),
        ]);
        $this->assertTrue($line->isReach());

        $line = new Line([
            new Cell(1, true),
            new Cell(2, true),
            new Cell(3, true),
            new Cell(4, true),
            new Cell(5, true),
        ]);
        $this->assertFalse($line->isReach());
    }
}
