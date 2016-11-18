<?php

require_once './TwitterAPIExchange.php';
require_once './config.php';

require_once '../../vendor/autoload.php';
use FuzzyAi\Client;

function byID($a, $b)
{
    if ($a->id < $b->id) {
        return -1;
    } elseif ($a->id > $b->id) {
        return 1;
    } else {
        return 0;
    }
}

function getTweets()
{
    global $twitterSettings;
    $url = 'https://api.twitter.com/1.1/statuses/home_timeline.json';
    $requestMethod = 'GET';
    $twitter = new TwitterAPIExchange($twitterSettings);

    $tweets = array();
    $twitter->buildOauth($url, $requestMethod);

    $response = $twitter->performRequest();

    $tweets = json_decode($response);

    return $tweets;
}

function byRelevance($a, $b)
{
    if ($a->relevance > $b->relevance) {
        return -1;
    } elseif ($a->relevance < $b->relevance) {
        return 1;
    } else {
        return 0;
    }
}

function ageInMinutes($tweet)
{
    return (time() - strtotime($tweet->created_at))/60;
}

function orderByRelevance($tweets)
{
    global $apiKey, $agentID;

    $client = new Client($apiKey);


    foreach ($tweets as $tweet) {
        $inputs = array("Number of likes" => $tweet->favorite_count,
                        "Number of shares" => $tweet->retweet_count,
                        "Age in minutes" => ageInMinutes($tweet));

        list($results, $evaluationID) = $client->evaluate($agentID, $inputs);

        if ($results) {
            $tweet->relevance = $results->relevance;
        }
    }

    usort($tweets, 'byRelevance');

    return $tweets;
}

$tweets = getTweets();
$tweets = orderByRelevance($tweets);

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Tweets by relevance</title>
  </head>
  <body>
    <div>
      <?php foreach ($tweets as $tweet) { ?>
        <div>
          <p><b><?php echo $tweet->user->screen_name ?></b> <em><?php echo $tweet->created_at ?></em> <?php echo $tweet->text ?> (<?php echo $tweet->relevance ?>)</p>
        </div>
      <?php } ?>
    </div>
  </body>
</html>
