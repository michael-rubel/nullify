<?php

declare(strict_types=1);

use MichaelRubel\Nullify\Nullify;

if (! function_exists('nullify')) {
    function nullify(mixed $values): mixed
    {
        return (new Nullify)($values);
    }
}
