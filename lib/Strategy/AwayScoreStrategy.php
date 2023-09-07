<?php
/**
 * © Copyrights reserved by Luxurno Marcin Szostak.
 * All rights reserved.
 */

declare(strict_types=1);

namespace Sportradar\Library\Scoreboard\Strategy;

use Sportradar\Library\Scoreboard\Event\AwayScoreEvent;
use Sportradar\Library\Scoreboard\IncomingEvent;
use Sportradar\Library\Scoreboard\Model\Score;

class AwayScoreStrategy implements ScoreboardStrategyInterface
{
    public function isValid(string $eventType): bool
    {
        return AwayScoreEvent::EVENT === $eventType;
    }

    public function handle(array $scoreboard, IncomingEvent $event): array
    {
        /** @var Score $score */
        $score = $scoreboard['away'];
        $score->addScore();

        return $scoreboard;
    }
}
