<?php
/**
 * © Copyrights reserved by Luxurno Marcin Szostak.
 * All rights reserved.
 */

declare(strict_types=1);

namespace Sportradar\Library\Scoreboard;

use PHPUnit\Framework\TestCase;
use Sportradar\Library\Scoreboard\Exception\MatchNotFoundException;
use Sportradar\Library\Scoreboard\Strategy\Exception\InvalidStrategyException;

class ScoreboardClientTest extends TestCase
{
    public function testSimpleMatch(): void
    {
        $scoreboardClient = new ScoreboardClient();

        $message = 'StartMatch|Mexico - Canada';
        $scoreboardClient->handle($message);

        $expected = '{"Mexico - Canada":{"home":0,"away":0}}';

        self::assertEquals($expected, json_encode($scoreboardClient->getMatches()));
    }

    public function testSimpleMatchFinishingGameAndRemoveFromScoreboard(): void
    {
        $scoreboardClient = new ScoreboardClient();

        $message = 'StartMatch|Mexico - Canada';
        $scoreboardClient->handle($message);

        $message = 'EndMatch|Mexico - Canada';
        $scoreboardClient->handle($message);

        $expected = '[]';

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

    public function testEventThatIsNotSupported(): void
    {
        $scoreboardClient = new ScoreboardClient();

        $message = 'StartMatch|Mexico - Canada';
        $scoreboardClient->handle($message);

        $this->expectException(InvalidStrategyException::class);

        $message = 'UpdateMatch|Mexico - Canada|OtherScore|2:1';
        $scoreboardClient->handle($message);
    }

    public function testSortScoreboard(): void
    {
        $scoreboardClient = new ScoreboardClient();

        // Match no.1
        $message = 'StartMatch|Mexico - Canada';
        $scoreboardClient->handle($message);
        $message = 'UpdateMatch|Mexico - Canada|UpdateScore|0:5';
        $scoreboardClient->handle($message);

        // Match no.2
        $message = 'StartMatch|Spain - Brazil';
        $scoreboardClient->handle($message);
        $message = 'UpdateMatch|Spain - Brazil|UpdateScore|10:2';
        $scoreboardClient->handle($message);

        // Match no.3
        $message = 'StartMatch|Germany - France';
        $scoreboardClient->handle($message);
        $message = 'UpdateMatch|Germany - France|UpdateScore|2:2';
        $scoreboardClient->handle($message);

        // Match no.4
        $message = 'StartMatch|Uruguay - Italy';
        $scoreboardClient->handle($message);
        $message = 'UpdateMatch|Uruguay - Italy|UpdateScore|6:6';
        $scoreboardClient->handle($message);

        // Match no.5
        $message = 'StartMatch|Argentina - Australia';
        $scoreboardClient->handle($message);
        $message = 'UpdateMatch|Argentina - Australia|UpdateScore|3:1';
        $scoreboardClient->handle($message);

        $expected = '{"Uruguay - Italy":{"home":6,"away":6},"Spain - Brazil":{"home":10,"away":2},"Mexico - Canada":{"home":0,"away":5},"Germany - France":{"home":2,"away":2},"Argentina - Australia":{"home":3,"away":1}}';

        self::assertEquals($expected, json_encode($scoreboardClient->getSortScoreboard()));
    }
}
