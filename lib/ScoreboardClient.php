<?php
/**
 * © Copyrights reserved by Luxurno Marcin Szostak.
 * All rights reserved.
 */

declare(strict_types=1);

namespace Sportradar\Library\Scoreboard;

class ScoreboardClient
{
    public function __construct(
        private array $matchesPool = [],
    ) { }

    public function handle(string $eventString): void
    {
        
    }

    public function getMatches(): array
    {
        return $this->matchesPool;
    }
}
