<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Clients\Mysql;

final class NumberRepository
{
    private Mysql $mysql;

    public function __construct()
    {
        $this->mysql = new Mysql();
    }

    /**
     * 初期化
     */
    public function init(int $maxNumber): void
    {
        $numbers = array_map(fn ($number) => "($number)", range(1, $maxNumber));

        $this->mysql->query(
            'INSERT INTO Numbers (`value`) VALUES ' . implode(',', $numbers)
        );
    }

    /**
     * リセット
     */
    public function reset(): void
    {
        $this->mysql->query('TRUNCATE TABLE Numbers');
    }

    /**
     * ランダムな数字を取得して削除する
     */
    public function rand(): int
    {
        $result = $this->mysql->query('SELECT `value` FROM Numbers ORDER BY RAND() LIMIT 1');
        $this->mysql->query('DELETE FROM Numbers WHERE `value` = ' . $result[0]['value']);

        return (int) $result[0]['value'];
    }
}
