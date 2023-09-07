<?php
/**
 * © Copyrights reserved by Luxurno Marcin Szostak.
 * All rights reserved.
 */

declare(strict_types=1);

namespace Sportradar\Library\Scoreboard;

use Sportradar\Library\Scoreboard\Exception\MatchNotFoundException;
use Sportradar\Library\Scoreboard\Factory\ScoreboardFactoryInterface;
use Sportradar\Library\Scoreboard\Strategy\AwayScoreStrategy;
use Sportradar\Library\Scoreboard\Strategy\HomeScoreStrategy;

readonly class ScoreboardService
{
    private ScoreboardContext $scoreboardContext;

    public function __construct(
        private ScoreboardFactoryInterface $factory
    ) {
        $this->scoreboardContext = new ScoreboardContext();
        $this->scoreboardContext->addStrategy(new HomeScoreStrategy());
        $this->scoreboardContext->addStrategy(new AwayScoreStrategy());
    }

    public function startMatch(): array
    {
        return [
            'home' => $this->factory->createHomeScore(),
            'away' => $this->factory->createAwayScore(),
        ];
    }

    public function updateMatch(
        array $scoreboard,
        string $eventType,
        string $payload,
    ): array
    {
        $event = new IncomingEvent($payload);

        return $this->scoreboardContext->handle($scoreboard, $eventType, $event);
    }

    public function endMatch(array $matches, string $payload): array
    {
        if (false === array_key_exists($payload, $matches)) {
            throw new MatchNotFoundException('Could not end not started match');
        }

        return [];
    }

    public function handle(IncomingEvent $event): void
    {

    }
}
