### ScoreboardClient
This class holds all running matches with pool solution

```php 
$scoreboardClient = new ScoreboardClient();

$message = 'StartMatch|Mexico - Canada';
$scoreboardClient->handle($message);
```
Usage of event for HomeScore
```php
$message = 'UpdateMatch|Mexico - Canada|HomeScore';
$scoreboardClient->handle($message);
```

Usage of event for AwayScore
```php
$message = 'UpdateMatch|Mexico - Canada|AwayScore';
$scoreboardClient->handle($message);
```

Usage of event for UpdateScore
```php
$message = 'UpdateMatch|Mexico - Canada|AwayScore';
$scoreboardClient->handle($message);
```

Receiving Scoreboard
```php
$scoreboardClient->getSortScoreboard()
```

Receiving Sorted Scoreboard
```php
$scoreboardClient->getMatches()
```
