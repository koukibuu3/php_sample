<?php

declare(strict_types=1);

echo 'Hello World!';

$hoge = $_GET['hoge'] ?? 'default';
var_dump($hoge);

foreach (['foo', 'bar', 'baz'] as $item) {
    echo $item;
}
