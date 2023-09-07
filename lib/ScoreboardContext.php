<?php
/**
 * © Copyrights reserved by Luxurno Marcin Szostak.
 * All rights reserved.
 */

declare(strict_types=1);

use Strategy\ScoreboardStrategyInterface;

class ScoreboardContext
{
    private array $strategies = [];

    public function handle(IncomingEvent $eventType): void
    {
        /** @var ScoreboardStrategyInterface $strategy */
        foreach ($this->strategies as $strategy) {
            if ($strategy->isValid($eventType->getType())) {
                $strategy->handle($eventType);
            }
        }
    }
}
