<?php

declare(strict_types=1);

namespace Root\App;

final class Customer
{
    public function __construct(
        public readonly string $firstname,
        public readonly string $lastname,
        public readonly string $phoneNumber,
        public readonly string  $address,
        public readonly string $birthData
    )
    {
    }
}