<?php

namespace App\Interfaces;

interface Arrayable
{
    /**
     * Get the instance as an array.
     */
    public function toArray(): array;
}