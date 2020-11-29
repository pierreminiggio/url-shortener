<?php

namespace App\Entity;

class Redirection
{
    public function __construct(
        public int $id,
        public string $from,
        public string $to,
    )
    {}
}
