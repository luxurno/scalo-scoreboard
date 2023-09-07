<?php
/**
 * © Copyrights reserved by Luxurno Marcin Szostak.
 * All rights reserved.
 */

declare(strict_types=1);

class Score
{
    public function __construct(
        private int $score = 0
    ) { }

    public function updateScore(int $score): void
    {
        $this->score = $score;
    }

    public function addScore(): void
    {
        $this->score += 1;
    }

    public function getScore(): int
    {
        return $this->score;
    }
}