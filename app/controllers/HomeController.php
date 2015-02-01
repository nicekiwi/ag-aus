<?php

use SteamCondenser\Servers\GoldSrcServer;

class HomeController extends BaseController {

	protected $layout = 'layouts.master';

	public function __construct()
	{
		$this->groupUrl = 'http://steamcommunity.com/groups/AG-Aus';
	}

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function index_public()
	{
		// Return donate with quarter data
		$this->layout->bodyClass = 'homepage';
		$this->layout->content = View::make('index');
	}

	public function getServerStatus()
	{
		$input = Input::all();

		if(!isset($input['ip']) || !isset($input['port']))
		{
			return false;
		}

		$hash = md5($input['ip'].$input['port']);

		// Cached for 60 seconds
		return Cache::remember('steam-server-status-' . $hash , 1, function() use ($input)
		{
			try
			{
				$server = new GoldSrcServer((string)$input['ip'], (int)$input['port']);
				$server->initialize();

				$info = $server->getServerInfo();
			}
			catch(ErrorException $e)
			{
				$info = '';
			}

			return json_encode($info);
		});
	}

	public function getGroupNews($slug=null,$id=null)
	{
		$xml = Cache::remember('steam-group-news', 15, function()
		{
			return @file_get_contents($this->groupUrl . '/rss/');
		});

		$xml = simplexml_load_string($xml);

		$posts = [];

		foreach ($xml->channel->item as $item)
		{
			$post = new StdClass;

			$post->link = (string)$item->link;

			$newId = explode('/', $post->link);

			$post->id = $newId[count($newId)-1];
			$post->title = (string)$item->title;
			$post->slug = Str::slug($post->title);
			$post->author = (string)$item->author;

			$post->descHtml = (string)$item->description;

			$desc = strip_tags($post->descHtml);
			$desc = preg_replace('/\s+/', ' ', $desc);
			$desc = trim(substr($desc, 0, 100)) . '...';
			$post->desc = $desc;


			$post->date = date('d/m', strtotime((string)$item->pubDate));

			$posts[] = $post;

			if(!is_null($id) && $id === $post->id)
			{
				return View::make('news.show')->with(compact('post'));
			}
		}

		return View::make('news.index')->with(compact('posts'));
	}

	public function getGroupEvent($slug,$id)
	{
		$html = Cache::remember('steam-group-event-' . $id, 15, function() use ($id)
		{
			return @file_get_contents($this->groupUrl . '/events/' . $id . '?content_only=true');
		});

		$crawler = new Symfony\Component\DomCrawler\Crawler((string)$html);

		$event = new StdClass;

		$event->id = $id;
		$event->logo = $crawler->filter('.gameLogo img')->attr('src');
		$event->title = $crawler->filter('.large_title')->text();
		$event->time = $crawler->filter('.announcement_byline > span')->text();
		$event->author = $crawler->filter('.announcement_byline > a')->text();
		$event->desc = $crawler->filter('.eventContent')->text();

		return View::make('events.show')->with([
			'event' => $event
		]);
	}

	public function getGroupEvents()
	{
		$xml = Cache::remember('upcoming-steam-group-events', 15, function()
		{
			$today = \Carbon\Carbon::today();
			return @file_get_contents($this->groupUrl . '/events?xml=1&action=eventFeed&month=' . $today->month . '&year=' . $today->year);
		});

		$xml = simplexml_load_string($xml);

		$elements = [$xml->event,$xml->expiredEvent];

		$events = [];
		$pastEvents = [];

		foreach ($elements as $key => $element)
		{
			foreach ($element as $exp)
			{
				$crawler = new Symfony\Component\DomCrawler\Crawler((string)$exp);

				$id = $crawler->filter('.eventBlock')->attr('id');
				$day = $crawler->filter('.eventDateBlock > span')->text();
				$time = $crawler->filter('.eventDateTime')->text();
				$title = $crawler->filter('.headlineLink')->text();

				$event = new StdClass;
				$event->date = date('d/m/y', strtotime($time . ' ' . $day . ' ' . $month . ' ' . $year));
				$event->title = $title;
				$event->slug = Str::slug($event->title) . '/' . str_replace('_eventBlock', '', $id);

				if($key > 0)
				{
					$pastEvents[] = $event;
				}
				else
				{
					$events[] = $event;
				}

			}
		}

		return View::make('events.index')->with([
			'events' => $events,
			'pastEvents' => $pastEvents
		]);
	}

	public function getGroupDiscussions()
	{
		$html = Cache::remember('recent-steam-group-discussions', 60, function()
		{
			return @file_get_contents('http://steamcommunity.com/groups/AG-Aus/discussions/0?content_only=true');
		});

		$crawler = new Symfony\Component\DomCrawler\Crawler((string)$html);

		$posts = $crawler->filter('.forum_topic')->each(function ($node,$i)
		{
			$post = new StdClass;

			$date = $node->filter('.forum_topic_lastpost')->text();
			$date = str_replace(' @', '', trim($date));

			if(strstr($date,','))
			{
				$dateObject = \Carbon\Carbon::createFromFormat('j M, Y g:ia', $date);
			}
			else
			{
				$dateObject = \Carbon\Carbon::createFromFormat('j M g:ia', $date);
			}

			$topicName = $node->filter('.forum_topic_name')->text();

			$post->lastPostDate = $dateObject;
			$post->lastPostDatePretty = $dateObject->diffForHumans();
			$post->topicName = trim(str_replace('PINNED:','',$topicName));
			$post->lastPoster = trim($node->filter('.forum_topic_op')->text());
			$post->link = $node->filter('.forum_topic_overlay')->attr('href');

			return $post;
		});

		usort($posts, function($a, $b) {
			return $b->lastPostDate->format('U') - $a->lastPostDate->format('U');
		});

		return json_encode($posts);
	}

}