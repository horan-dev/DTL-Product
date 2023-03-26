<?php

namespace Domain\Client\Data;

use Shared\Bases\Data;

class LoginData extends Data
{
    public function __construct(
        public string $email,
        public ?string $password,
    ) {
    }
}
