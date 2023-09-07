<?php
/**
 * © Copyrights reserved by Luxurno Marcin Szostak.
 * All rights reserved.
 */

declare(strict_types=1);

namespace Sportradar\Library\Scoreboard\GlobalEvent;

abstract class GlobalEvent
{
    public function __construct(
        private readonly string $payload,
        private readonly string $eventType = '',
        private readonly string $additionalInformation = '',
    ) { }

    public function getPayload(): string
    {
        return $this->payload;
    }

    public function getEventType(): string
    {
        return $this->eventType;
    }

    public function getAdditionalInformation(): string
    {
        return $this->additionalInformation;
    }
}
