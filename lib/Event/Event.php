<?php
/**
 * © Copyrights reserved by Luxurno Marcin Szostak.
 * All rights reserved.
 */

declare(strict_types=1);

namespace Event;

abstract class Event
{
    public const EVENT = self::class;

    public function __construct(
        private readonly string $payload,
    ) { }

    public function getPayload(): string
    {
        return $this->payload;
    }
}
