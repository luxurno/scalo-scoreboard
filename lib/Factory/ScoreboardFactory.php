<?php
/**
 * © Copyrights reserved by Luxurno Marcin Szostak.
 * All rights reserved.
 */

declare(strict_types=1);

namespace Sportradar\Library\Scoreboard\Factory;

use Sportradar\Library\Scoreboard\Model\Score;

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
