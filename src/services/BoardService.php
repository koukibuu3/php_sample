<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\Board;
use App\Repositories\BoardRepository;
use App\Repositories\NumberRepository;

/**
 * ビンゴカードのサービス
 */
class BoardService
{
    public function __construct(
        private readonly BoardRepository $boardRepository,
        private readonly NumberRepository $numberRepository,
    ) {
    }

    /**
     * リセット
     */
    public function reset(): void
    {
        $this->boardRepository->reset();
        $this->numberRepository->reset();
    }

    /**
     * 初期化
     *
     * @param string[] $owners
     */
    public function init(array $owners): void
    {
        $this->initBoards($owners);
        $this->initNumbers();
    }

    /**
     * ビンゴカードの初期化
     *
     * @param string[] $owners
     */
    private function initBoards(array $owners): void
    {
        $this->boardRepository->reset();
        foreach ($owners as $owner) {
            $this->boardRepository->add($owner);
        }
    }

    /**
     * 数字の初期化
     */
    private function initNumbers(): void
    {
        $this->numberRepository->reset();
        $this->numberRepository->init(Board::DEFAULT_MAX_NUMBER);
    }

    /**
     * ビンゴを回す
     */
    public function roll(): void
    {
        $number = $this->numberRepository->rand();
        $this->boardRepository->hit($number);
    }
}
