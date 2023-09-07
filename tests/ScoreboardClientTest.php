<?php
/**
 * © Copyrights reserved by Luxurno Marcin Szostak.
 * All rights reserved.
 */

declare(strict_types=1);

namespace Sportradar\Library\Scoreboard;

use PHPUnit\Framework\TestCase;

class ScoreboardClientTest extends TestCase
{
    public function testSimpleMatch(): void
    {
        $scoreboardClient = new ScoreboardClient();

        $message = 'StartMatch|Mexico - Canada';
        $scoreboardClient->handle($message);

        $message = 'EndMatch|Mexico - Canada';
        $scoreboardClient->handle($message);

        $expected = '{"Mexico-Canada":"0:0"}';

        self::assertEquals($expected, $scoreboardClient->getMatches());
    }
}
