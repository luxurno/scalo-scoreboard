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
use Sportradar\Library\Scoreboard\GlobalEvent\UpdateMatchGlobalEvent;
use Sportradar\Library\Scoreboard\Model\Score;

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
            UpdateMatchGlobalEvent::GLOBAL_EVENT =>
                $this->scoreboardService->updateMatch(
                    $this->matches[$globalEvent->getPayload()],
                    $globalEvent->getEventType(),
                    $globalEvent->getAdditionalInformation(),
                ),
            EndMatchGlobalEvent::GLOBAL_EVENT =>
                $this->scoreboardService->endMatch($this->matches, $globalEvent->getPayload()),
        };

        switch ($globalEvent::class) {
            case UpdateMatchGlobalEvent::GLOBAL_EVENT:
            case StartMatchGlobalEvent::GLOBAL_EVENT:
                $this->matches[$globalEvent->getPayload()] = $result;
                break;
            case EndMatchGlobalEvent::GLOBAL_EVENT:
                unset($this->matches[$globalEvent->getPayload()]);
        }
    }

    public function getSortScoreboard(): array
    {
        $matches = [];
        foreach ($this->matches as $matchName => $match) {
            /** @var Score $homeScore */
            $homeScore = $match['home'];
            /** @var Score $awayScore */
            $awayScore = $match['away'];

            $matches[$matchName] = $homeScore->getScore() + $awayScore->getScore();
        }
        krsort($matches);

        $returnMatches = [];
        foreach ($matches as $matchName => $score) {
            $returnMatches[$matchName] = $this->matches[$matchName];
        }

        return $returnMatches;
    }

    public function getMatches(): array
    {
        return $this->matches;
    }
}
