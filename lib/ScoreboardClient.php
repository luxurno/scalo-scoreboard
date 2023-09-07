<?php
/**
 * © Copyrights reserved by Luxurno Marcin Szostak.
 * All rights reserved.
 */

declare(strict_types=1);

namespace Sportradar\Library\Scoreboard;

use Sportradar\Library\Scoreboard\Core\GlobalEventResolver;
use Sportradar\Library\Scoreboard\Factory\ScoreboardFactory;
use Sportradar\Library\Scoreboard\GlobalEvent\EndMatchGlobalEvent;
use Sportradar\Library\Scoreboard\GlobalEvent\StartMatchGlobalEvent;

class ScoreboardClient
{
    private ScoreboardService $scoreboardService;
    public function __construct(
        private array $matches = [],
    ) {
        $this->scoreboardService = new ScoreboardService(new ScoreboardFactory());
    }

    public function handle(string $eventString): void
    {
        $globalEvent = GlobalEventResolver::resolve($eventString);

        $result = match($globalEvent::class) {
            StartMatchGlobalEvent::GLOBAL_EVENT =>
                $this->scoreboardService->startMatch(),
            EndMatchGlobalEvent::GLOBAL_EVENT =>
                $this->scoreboardService->endMatch($this->matches, $globalEvent->getPayload()),
        };

        switch ($globalEvent::class) {
            case StartMatchGlobalEvent::GLOBAL_EVENT:
                $this->matches[$globalEvent->getPayload()] = $result;
                break;
        }
    }

    public function getMatches(): array
    {
        return $this->matches;
    }
}
