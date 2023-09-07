<?php
/**
 * © Copyrights reserved by Luxurno Marcin Szostak.
 * All rights reserved.
 */

declare(strict_types=1);

namespace Sportradar\Library\Scoreboard;

use Sportradar\Library\Scoreboard\Strategy\ScoreboardStrategyInterface;

class ScoreboardContext
{
    private array $strategies = [];

    public function addStrategy(ScoreboardStrategyInterface $strategy): void
    {
        $this->strategies[] = $strategy;
    }

    public function handle(array $scoreboard, string $eventType, IncomingEvent $event): array
    {
        /** @var ScoreboardStrategyInterface $strategy */
        foreach ($this->strategies as $strategy) {
            if ($strategy->isValid($eventType)) {
                return $strategy->handle($scoreboard, $event);
            }
        }
    }
}
