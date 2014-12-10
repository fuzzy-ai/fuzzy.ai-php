<?php

require_once '../fuzzy.io.php';
require_once './TwitterAPIExchange.php';

require_once './config.php';

/* This gets about the maximum number of tweets from your home timeline.
 * Twitter says ~800, so it gets 4 pages of 200. */

function byID($a, $b) {
  if ($a->id < $b->id) {
    return -1;
  } else if ($a->id > $b->id) {
    return 1;
  } else {
    return 0;
  }
}

function getTweets() {
  global $twitterSettings;
  $url = 'https://api.twitter.com/1.1/statuses/home_timeline.json';
  $requestMethod = 'GET';
  $twitter = new TwitterAPIExchange($twitterSettings);

  $tweets = array();

  for ($i = 0; $i < 4; $i++) {

    $getfield = '?count=200';

    if (count($tweets) > 0) {
      usort($tweets, 'byID');
      $min_id = $tweets[0]->id;
      $getfield .= "&max_id=$min_id";
    } else {
      $min_id = null;
    }

    $twitter->setGetfield($getfield);
    $twitter->buildOauth($url, $requestMethod);

    $response = $twitter->performRequest();

    $newTweets = json_decode($response);

    /* Avoid duplicates */

    if ($min_id) {
      $k = null;
      for ($j = 0; $j < count($newTweets); $j++) {
        $tweet = $newTweets[$j];
        if ($tweet->id == $min_id) {
          $k = $j;
          break;
        }
      }
      if ($k) {
        $newTweets = array_splice($newTweets, $k, 1);
      }
    }

    $tweets = array_merge($tweets, $newTweets);
  }

  return $tweets;
}

function byRelevance($a, $b) {
    if ($a->relevance > $b->relevance) {
      return -1;
    } else if ($a->relevance < $b->relevance) {
      return 1;
    } else {
      return 0;
    }
}

function ageInMinutes($tweet) {
  return (time() - strtotime($tweet->created_at))/60;
}

function orderByRelevance($tweets) {

  global $apiKey, $agentID;

  $server = new FuzzyServer($apiKey);
  $agent = $server->getAgent($agentID);

  foreach ($tweets as $tweet) {
    $results = $agent->evaluate(array("numberOfLikes" => $tweet->favorite_count,
                                      "numberOfShares" => $tweet->retweet_count,
                                      "age" => ageInMinutes($tweet)));

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
