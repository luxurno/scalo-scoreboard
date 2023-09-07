<?php
/**
 * © Copyrights reserved by Luxurno Marcin Szostak.
 * All rights reserved.
 */

declare(strict_types=1);

namespace Sportradar\Library\Scoreboard\Strategy;

use Sportradar\Library\Scoreboard\IncomingEvent;

interface ScoreboardStrategyInterface
{
    public function isValid(string $eventType): bool;
    public function handle(array $scoreboard, IncomingEvent $event): array;
}
