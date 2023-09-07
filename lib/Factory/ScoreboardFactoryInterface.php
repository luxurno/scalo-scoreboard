<?php
/**
 * © Copyrights reserved by Luxurno Marcin Szostak.
 * All rights reserved.
 */

declare(strict_types=1);

namespace Factory;
use Score;

interface ScoreboardFactoryInterface
{
    public function createHomeScore(): Score;
    public function createAwayScore(): Score;
}
