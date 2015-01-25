@extends('layouts.master')

@section('content')

    <section class="content-shade welcome">
		<h2>The 411</h2>
		<p class="opening">AG is an alternative-friendly online community. Whether you&rsquo;re gay, bi, trans, straight, a fur&thinsp;&mdash;&thinsp;or whatever other yummy flavour&thinsp;&mdash;&thinsp;we all have one thing in common: we love TF2<span class="highlight">*</span>.</p>
		<p>We&rsquo;re a bunch of kids who get up to kinky gay sex and play video games. On a more serious note, the group is for gamers with an open mind; it&rsquo;s founded by a furry and a general alt scene kid (those emo buggers).</p>
		<p class="note"><span class="highlight">* </span>we play other games too!</p>
		<p class="note"><span class="highlight">&diams; </span>18+ images permitted, but illegal stuff is still illegal</p>
	</section>
	
	<section class="content-shade about-us">
		<h2>The Gamer Manifesto</h2>
		<p>We don&rsquo;t want to be too moralistic but we like to promote the value of good sportsmanship and generally <strong>not</strong> being a dickhead.</p>
		<p>Akin to <a target="_blank" href="http://day9.tv/manifesto/" title="Day[9]TV: Manifesto">what Day[9] once wrote</a>: &ldquo;We&rsquo;re a broad community, intelligent, curious, ambitious, and competitive. We are gamers, and we&rsquo;re pretty intolerant of bullsh*t.</p>
		<p>Play keeps us curious, imaginative, and teaches us to learn from our mistakes and improve ourselves. Play develops bonds and has created many lasting friendships and communities.&rdquo;</p>
		<br />
		<p class="donation"><strong>Donations?</strong> Our servers cost money which l&uuml;ffy &amp; Virtue pay for out of their own pockets. <a class="" href="/donate" title="Donate">We do accept donations</a>.</p>
	</section>

	<section class="content-shade recent-forum">
		<h2>Recent forum posts</h2>
		<p>We don&rsquo;t want to be too moralistic but we like to promote the value of good sportsmanship and generally <strong>not</strong> being a dickhead.</p>
		<p>Akin to <a href="http://day9.tv/manifesto/" title="Day[9]TV: Manifesto">what Day[9] once wrote</a>: &ldquo;We&rsquo;re a broad community, intelligent, curious, ambitious, and competitive. We are gamers, and we&rsquo;re pretty intolerant of bullsh*t.</p>
		<p>Play keeps us curious, imaginative, and teaches us to learn from our mistakes and improve ourselves. Play develops bonds and has created many lasting friendships and communities.&rdquo;</p>
		<br />
		<p class="donation"><strong>Donations?</strong> Our servers cost money which l&uuml;ffy &amp; Virtue pay for out of their own pockets. <a class="external" href="http://pledgie.com/campaigns/17432" title="Donate at Pledgie.com">We do accept donations</a>.</p>
	</section>

	<section class="content-shade upcoming-events">
		<h2>Upcoming Events</h2>
		<p>We don&rsquo;t want to be too moralistic but we like to promote the value of good sportsmanship and generally <strong>not</strong> being a dickhead.</p>
		<p>Akin to <a href="http://day9.tv/manifesto/" title="Day[9]TV: Manifesto">what Day[9] once wrote</a>: &ldquo;We&rsquo;re a broad community, intelligent, curious, ambitious, and competitive. We are gamers, and we&rsquo;re pretty intolerant of bullsh*t.</p>
		<p>Play keeps us curious, imaginative, and teaches us to learn from our mistakes and improve ourselves. Play develops bonds and has created many lasting friendships and communities.&rdquo;</p>
		<br />
		<p class="donation"><strong>Donations?</strong> Our servers cost money which l&uuml;ffy &amp; Virtue pay for out of their own pockets. <a class="external" href="http://pledgie.com/campaigns/17432" title="Donate at Pledgie.com">We do accept donations</a>.</p>
	</section>

	<section class="content-shade announcments">
		<h2>Announcments</h2>
		<p>We don&rsquo;t want to be too moralistic but we like to promote the value of good sportsmanship and generally <strong>not</strong> being a dickhead.</p>
		<p>Akin to <a href="http://day9.tv/manifesto/" title="Day[9]TV: Manifesto">what Day[9] once wrote</a>: &ldquo;We&rsquo;re a broad community, intelligent, curious, ambitious, and competitive. We are gamers, and we&rsquo;re pretty intolerant of bullsh*t.</p>
		<p>Play keeps us curious, imaginative, and teaches us to learn from our mistakes and improve ourselves. Play develops bonds and has created many lasting friendships and communities.&rdquo;</p>
		<br />
		<p class="donation"><strong>Donations?</strong> Our servers cost money which l&uuml;ffy &amp; Virtue pay for out of their own pockets. <a class="external" href="http://pledgie.com/campaigns/17432" title="Donate at Pledgie.com">We do accept donations</a>.</p>
	</section>

@stop

@section('footer')

	<script>

		function getNews(){

			$.get('http://steamcommunity.com/groups/AG-Aus/rss/?callback=0', function (data) {
				$(data).find("item").each(function () { // or "item" or whatever suits your feed
					var el = $(this);

					console.log("------------------------");
					console.log("title      : " + el.find("title").text());
					console.log("author     : " + el.find("author").text());
					console.log("description: " + el.find("description").text());
				});
			});

		}

		$( document ).ready(function() {

			getNews();

		});

	</script>

@stop