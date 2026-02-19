<?php

declare(strict_types=1);

namespace AkselerasiPrimaDigital\FlipForBusinessPhp\Exceptions;

use Throwable;

class FlipException extends \RuntimeException
{
    public function __construct(string $message, ?int $status = null, ?Throwable $prev = null)
    {
        parent::__construct($status ? "$message (HTTP $status)" : $message, 0, $prev);
    }
}
