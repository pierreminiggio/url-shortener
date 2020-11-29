<?php

namespace App\Entity;

class Redirection
{
    public function __construct(
        private int $id,
        private string $from,
        private string $to,
    )
    {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getTo(): string
    {
        return $this->to;
    }
}
