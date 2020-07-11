<?php

namespace App\Contracts;

interface HashGenerationService
{
    /**
     * @return string
     */
    public function createHash(): string;
}
