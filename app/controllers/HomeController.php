<?php

use SteamCondenser\Servers\GoldSrcServer;
use Symfony\Component\DomCrawler\Crawler;
use Carbon\Carbon;

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

//	public function getGroupNewsJson()
//	{
//		return $this->getGroupNews(null,null,true);
//	}

	public function getGroupNews($slug=null,$id=null,$json=null)
	{
		$xml = Cache::remember('steam-group-news', 15, function()
		{
			return @file_get_contents($this->groupUrl . '/rss/');
		});

		$xml = simplexml_load_string($xml);

		$posts = [];

		if(!$xml)
		{
			return $posts;
		}

		foreach ($xml->channel->item as $item)
		{
			$post = new StdClass;

			$post->link = (string)$item->link;

			//$newId = explode('/', $post->link);

			//$post->id = $newId[count($newId)-1];
			$post->title = (string)$item->title;
			//$post->slug = Str::slug($post->title);
			$post->author = (string)$item->author;

//			$post->descHtml = (string)$item->description;
//
//			$desc = strip_tags($post->descHtml);
//			$desc = preg_replace('/\s+/', ' ', $desc);
//			$desc = trim(substr($desc, 0, 100)) . '...';
//			$post->desc = $desc;


			$post->date = date('jS M', strtotime((string)$item->pubDate));


			$posts[] = $post;

//			if(!is_null($id) && $id === $post->id)
//			{
//				return View::make('news.show')->with(compact('post'));
//			}
		}

		//if(!is_null($json))
		//{
			return json_encode($posts);
		//}

		//return View::make('news.index')->with(compact('posts'));
	}

//	public function getGroupEvent($slug,$id)
//	{
//		$html = Cache::remember('steam-group-event-' . $id, 15, function() use ($id)
//		{
//			return @file_get_contents($this->groupUrl . '/events/' . $id . '?content_only=true');
//		});
//
//		$crawler = new Crawler((string)$html);
//
//		$event = new StdClass;
//
//		$event->id = $id;
//		$event->logo = $crawler->filter('.gameLogo img')->attr('src');
//		$event->title = $crawler->filter('.large_title')->text();
//		$event->time = $crawler->filter('.announcement_byline > span')->text();
//		$event->author = $crawler->filter('.announcement_byline > a')->text();
//		$event->desc = $crawler->filter('.eventContent')->text();
//
//		return View::make('events.show')->with([
//			'event' => $event
//		]);
//	}

//	public function getGroupEventsJson()
//	{
//		return $this->getGroupEvents(true);
//	}

	public function getGroupEvents($json=null)
	{
		$today = \Carbon\Carbon::today();
		$events = [];

		$xml = Cache::remember('upcoming-steam-group-events', 15, function() use ($today)
		{
			return @file_get_contents($this->groupUrl . '/events?xml=1&action=eventFeed&month=' . $today->month . '&year=' . $today->year);
		});



		$xml = simplexml_load_string($xml);



		//dd($xml->eventCount);

		//$elements = [$xml->event,$xml->expiredEvent];
		//$events = $xml->events;

		if($xml->eventCount == 0 || !$xml)
		{
			return $events;
		}
		//$pastEvents = [];

		//foreach ($elements as $key => $element)
		//{
			//foreach ($element as $exp)
			foreach ($xml->event as $exp)
			{
				$crawler = new Crawler((string)$exp);

				$id = $crawler->filter('.eventBlock')->attr('id');
				$day = $crawler->filter('.eventDateBlock > span')->text();
				$time = $crawler->filter('.eventDateTime')->text();
				$title = $crawler->filter('.headlineLink')->text();

				$date = $day . ' ' . $today->month . ' ' . $time;
				$date = Carbon::createFromFormat('l j n g:ia', $date);

				$event = new StdClass;
				$event->date = date('jS M, g:ia', $date->format('U'));
				$event->title = $title;
				//$event->slug = Str::slug($event->title) . '/' . str_replace('_eventBlock', '', $id);
				$event->link = $this->groupUrl . '/events/' . $id;

//				if($key > 0)
//				{
//					$pastEvents[] = $event;
//				}
//				else
//				{
					$events[] = $event;
//				}

			}
		//}

		//if(!is_null($json))
		//{
			return json_encode($events);
		//}

//		return View::make('events.index')->with([
//			'events' => $events,
//			'pastEvents' => $pastEvents
//		]);
	}

	public function getGroupDiscussions()
	{
		$html = Cache::remember('recent-steam-group-discussions', 60, function()
		{
			return @file_get_contents($this->groupUrl . '/discussions/0?content_only=true');
		});

		if(!$html)
		{
			return [];
		}

		$crawler = new Crawler((string)$html);

		$posts = $crawler->filter('.forum_topic')->each(function ($node,$i)
		{
			$post = new StdClass;

			$date = $node->filter('.forum_topic_lastpost')->text();
			$date = str_replace(' @', '', trim($date));

			if(strstr($date,','))
			{
				$dateObject = Carbon::createFromFormat('j M, Y g:ia', $date);
			}
			else
			{
				$dateObject = Carbon::createFromFormat('j M g:ia', $date);
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