<?php
/**
 * © Copyrights reserved by Luxurno Marcin Szostak.
 * All rights reserved.
 */

declare(strict_types=1);

namespace Sportradar\Library\Scoreboard;

readonly class IncomingEvent
{
    public function __construct(
        private string $payload,
    ) { }

    public function getPayload(): string
    {
        return $this->payload;
    }
}
