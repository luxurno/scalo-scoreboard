<?php
/**
 * © Copyrights reserved by Luxurno Marcin Szostak.
 * All rights reserved.
 */

declare(strict_types=1);

namespace Sportradar\Library\Scoreboard\Factory;
use Sportradar\Library\Scoreboard\Model\Score;

interface ScoreboardFactoryInterface
{
    public function createHomeScore(): Score;
    public function createAwayScore(): Score;
}
