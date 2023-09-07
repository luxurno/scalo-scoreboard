<?php
/**
 * © Copyrights reserved by Luxurno Marcin Szostak.
 * All rights reserved.
 */

declare(strict_types=1);

namespace Sportradar\Library\Scoreboard;

use PHPUnit\Framework\TestCase;
use Sportradar\Library\Scoreboard\Exception\MatchNotFoundException;

class ScoreboardClientTest extends TestCase
{
    public function testSimpleMatch(): void
    {
        $scoreboardClient = new ScoreboardClient();

        $message = 'StartMatch|Mexico - Canada';
        $scoreboardClient->handle($message);

        $message = 'EndMatch|Mexico - Canada';
        $scoreboardClient->handle($message);

        $expected = '{"Mexico - Canada":{"home":0,"away":0}}';

        self::assertEquals($expected, json_encode($scoreboardClient->getMatches()));
    }

    public function testSimpleMatchEndMatchEventBeforeStart(): void
    {
        $scoreboardClient = new ScoreboardClient();

        $this->expectException(MatchNotFoundException::class);

        $message = 'EndMatch|Mexico - Canada';
        $scoreboardClient->handle($message);
    }

    public function testHomeScoreForSimpleMatch(): void
    {
        $scoreboardClient = new ScoreboardClient();

        $message = 'StartMatch|Mexico - Canada';
        $scoreboardClient->handle($message);

        $message = 'UpdateMatch|Mexico - Canada|HomeScore';
        $scoreboardClient->handle($message);

        $expected = '{"Mexico - Canada":{"home":1,"away":0}}';

        self::assertEquals($expected, json_encode($scoreboardClient->getMatches()));
    }

    public function testAwayScoreForSimpleMatch(): void
    {
        $scoreboardClient = new ScoreboardClient();

        $message = 'StartMatch|Mexico - Canada';
        $scoreboardClient->handle($message);

        $message = 'UpdateMatch|Mexico - Canada|AwayScore';
        $scoreboardClient->handle($message);

        $expected = '{"Mexico - Canada":{"home":0,"away":1}}';

        self::assertEquals($expected, json_encode($scoreboardClient->getMatches()));
    }


    public function testUpdateScoreForSimpleMatch(): void
    {
        $scoreboardClient = new ScoreboardClient();

        $message = 'StartMatch|Mexico - Canada';
        $scoreboardClient->handle($message);

        $message = 'UpdateMatch|Mexico - Canada|UpdateScore|2:1';
        $scoreboardClient->handle($message);

        $expected = '{"Mexico - Canada":{"home":2,"away":1}}';

        self::assertEquals($expected, json_encode($scoreboardClient->getMatches()));
    }


}
