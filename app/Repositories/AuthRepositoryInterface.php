<?php

declare(strict_types=1);

namespace App\Repositories;

interface AuthRepositoryInterface
{
    public function login(array $credentials);
}
