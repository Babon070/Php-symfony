<?php

declare(strict_types=1);

namespace App\Component\User;

use Symfony\Component\Serializer\Attribute\Groups;

class ProductInfoDto
{
        public function __construct(
            #[Groups(['user:read', 'user:write'])]
            private string $price
        )
        {

        }

    public function getPrice(): string
    {
        return $this->price;
    }
}