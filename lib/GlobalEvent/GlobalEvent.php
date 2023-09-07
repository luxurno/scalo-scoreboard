<?php
/**
 * © Copyrights reserved by Luxurno Marcin Szostak.
 * All rights reserved.
 */

declare(strict_types=1);

namespace Sportradar\Library\Scoreboard\GlobalEvent;

abstract class GlobalEvent
{
    public const GLOBAL_EVENT = self::class;

    public function __construct(
        private readonly string $payload,
    ) { }

    public function getPayload(): string
    {
        return $this->payload;
    }
}
