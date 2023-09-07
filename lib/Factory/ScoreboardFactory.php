<?php
/**
 * © Copyrights reserved by Luxurno Marcin Szostak.
 * All rights reserved.
 */

declare(strict_types=1);

namespace Factory;

use Score;

class ScoreboardFactory implements ScoreboardFactoryInterface
{
    public function createHomeScore(): Score
    {
        return new Score();
    }

    public function createAwayScore(): Score
    {
        return new Score();
    }
}
