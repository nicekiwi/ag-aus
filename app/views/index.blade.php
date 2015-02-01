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
		<p>Akin to <a target="_blank" href="http://day9.tv/manifesto/" title="Day[9]TV: Manifesto">what Day[9] once wrote <small><i class="fa fa-external-link"></i></small></a>: &ldquo;We&rsquo;re a broad community, intelligent, curious, ambitious, and competitive. We are gamers, and we&rsquo;re pretty intolerant of bullsh*t.</p>
		<p>Play keeps us curious, imaginative, and teaches us to learn from our mistakes and improve ourselves. Play develops bonds and has created many lasting friendships and communities.&rdquo;</p>
		<br />
		<p class="donation"><strong>Donations?</strong> Our servers cost money which l&uuml;ffy &amp; Virtue pay for out of their own pockets. <a class="" href="/donate" title="Donate">We do accept donations</a>.</p>
	</section>

	<section class="content-shade">
		<h2>Recent Discussions</h2>
		<ul id="latest-discussions"></ul>
	</section>

	<section class="content-shade upcoming-events">
		<h2>Upcoming Events</h2>
		<ul id="upcoming-events"></ul>
	</section>

	<section class="content-shade announcments">
		<h2>Latest News</h2>
		<ul id="latest-news"></ul>
	</section>

	<section class="content-shade server-status">
		<h2>Server Status</h2>
		<ul id="server-status"></ul>
	</section>

@stop

@section('footer')

	<script>

		function getForumPosts(){

			$.getJSON('/get-steam-discussions', function (json) {

				$.each(json, function (index,data) { // or "item" or whatever suits your feed

					if(index > 4){
						return false;
					}

					var li = $('<li/>').append(
							$('<a/>', {'href':data.link, 'target':'_blank'}).html(data.topicName + ' <small><i class="fa fa-external-link"></i></small>'),
							$('<br/>'),
							$('<small/>').text(data.lastPoster + ' - ' + data.lastPostDatePretty)
					);

					$('#latest-discussions').append(li);

				});
			});

		}

		function getServerStatus() {

			var servers = [
				'203.33.121.205:27058','203.33.121.205:27021'
			];
			var serverBox = $('#server-status').html('');

			$.each(servers, function(index,server){

				server = server.split(':');

				var ip = server[0];
				var port = server[1];

				$.post('/get-steam-server-status', {
					ip: ip, port: port
				}, function(json){

					json = $.parseJSON(json);

					$('<li/>').text(ip + ':' + port + ' - ' + json.numberOfPlayers + '/' + json.maxPlayers).appendTo(serverBox);
				});


			});

			// Refresh every minute
			setTimeout(getServerStatus, 60000);

		}

		$( document ).ready(function() {

			getForumPosts();
			getServerStatus();

		});

	</script>

@stop