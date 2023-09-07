<?php
/**
 * © Copyrights reserved by Luxurno Marcin Szostak.
 * All rights reserved.
 */

declare(strict_types=1);

namespace Sportradar\Library\Scoreboard;

use Sportradar\Library\Scoreboard\Factory\ScoreboardFactoryInterface;

readonly class ScoreboardService
{
    public function __construct(
        private ScoreboardFactoryInterface $factory
    ) { }

    public function startMatch(): array
    {
        return [
            'home' => $this->factory->createHomeScore(),
            'away' => $this->factory->createAwayScore(),
        ];
    }

    public function endMatch(): array
    {
        return [];
    }

    public function handle(IncomingEvent $event): void
    {

    }
}
