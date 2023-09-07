<?php
/**
 * © Copyrights reserved by Luxurno Marcin Szostak.
 * All rights reserved.
 */

declare(strict_types=1);

namespace Sportradar\Library\Scoreboard\Core;

use Sportradar\Library\Scoreboard\GlobalEvent\GlobalEvent;

class GlobalEventResolver
{
    private const EVENTS_NAMESPACE = 'Sportradar\\Library\\Scoreboard\\GlobalEvent\\';

    public static function resolve(string $eventString): GlobalEvent
    {
        if (false !== str_contains('|', $eventString)) {
            throw new \InvalidArgumentException('Invalid GlobalEvent');
        }

        $data = explode('|', $eventString);
        $eventName = sprintf(self::EVENTS_NAMESPACE . '%sGlobalEvent', $data[0]);

        if (false !== str_contains('-', $data[1])) {
            throw new \InvalidArgumentException('Invalid `GlobalEvent` payload schema');
        }

        return new $eventName($data[1]);
    }
}
