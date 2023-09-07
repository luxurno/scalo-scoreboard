<?php
/**
 * © Copyrights reserved by Luxurno Marcin Szostak.
 * All rights reserved.
 */

declare(strict_types=1);

namespace Sportradar\Library\Scoreboard\Strategy;

use Sportradar\Library\Scoreboard\Event\UpdateScoreEvent;
use Sportradar\Library\Scoreboard\IncomingEvent;
use Sportradar\Library\Scoreboard\Model\Score;

class UpdateScoreStrategy implements ScoreboardStrategyInterface
{
    public function isValid(string $eventType): bool
    {
        return UpdateScoreEvent::EVENT === $eventType;
    }

    public function handle(array $scoreboard, IncomingEvent $event): array
    {
        if (false !== str_contains(":", $event->getPayload())) {
            throw new \InvalidArgumentException('Incorrect UpdateScore event schema');
        }

        $data = explode(':', $event->getPayload());

        /** @var Score $score */
        $score = $scoreboard['home'];
        $score->updateScore((int) $data[0]);

        /** @var Score $score */
        $score = $scoreboard['away'];
        $score->updateScore((int) $data[1]);

        return $scoreboard;
    }
}
