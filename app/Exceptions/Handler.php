<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\QueryException;

public function register(): void
{
    $this->reportable(function (Throwable $e) {
        if (str_contains($e->getMessage(), 'GMP or BCMath extension')) {
            return false;
        }
    });
}


