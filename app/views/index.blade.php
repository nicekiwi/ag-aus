@extends('layouts.master')

@section('content')

	<div class="col-sm-12 col-md-8">
		<section class="banner">
			<ol id="server-status">
				<li data-ip="203.33.121.205" data-port="27021">
					<a class="sbtn server-one" href="steam://connect/203.33.121.205:27021" title="Join Server #1">
						<div>
							<div class="server-title">Join Server #1</div>
							<div class="server-description"><b>Chill out + custom maps</b></div>
							<div class="server-information">
								<span class="players"></span>/<span class="maxPlayers"></span> - <span class="mapName"></span>
							</div>
						</div>
					</a>
				</li>
				<li data-ip="203.33.121.205" data-port="27058">
					<a class="sbtn server-two" href="steam://connect/203.33.121.205:27058" title="Join Server #2">
						<div>
							<div class="server-title">Join Server #2</div>
							<div class="server-description"><b>Highlander Mode</b></div>
							<div class="server-information">
								<span class="players"></span>/<span class="maxPlayers"></span> - <span class="mapName"></span>
							</div>
						</div>
					</a>
				</li>
			</ol>
		</section>

		<section class="content-shade the-411">
			<h2>The 411</h2>
			<p class="opening">AG is an alternative-friendly online community. Whether you&rsquo;re gay, bi, trans, straight, a fur&thinsp;&mdash;&thinsp;or whatever other yummy flavour&thinsp;&mdash;&thinsp;we all have one thing in common: we love TF2<span class="highlight">*</span>.</p>
			<p>We&rsquo;re a bunch of kids who get up to kinky gay sex and play video games. On a more serious note, the group is for gamers with an open mind; it&rsquo;s founded by a furry and a general alt scene kid (those emo buggers).</p>
			<p class="note"><span class="highlight">* </span>we play other games too!</p>
			<p class="note"><span class="highlight">&diams; </span>18+ images permitted, but illegal stuff is still illegal</p>
		</section>

		<section class="content-shade gamer-manifesto">
			<h2>The Gamer Manifesto</h2>
			<p>We don&rsquo;t want to be too moralistic but we like to promote the value of good sportsmanship and generally <strong>not</strong> being a dickhead.</p>
			<p>Akin to <a target="_blank" href="http://day9.tv/manifesto/" title="Day[9]TV: Manifesto">what Day[9] once wrote <small><i class="fa fa-external-link"></i></small></a>: &ldquo;We&rsquo;re a broad community, intelligent, curious, ambitious, and competitive. We are gamers, and we&rsquo;re pretty intolerant of bullsh*t.</p>
			<p>Play keeps us curious, imaginative, and teaches us to learn from our mistakes and improve ourselves. Play develops bonds and has created many lasting friendships and communities.&rdquo;</p>
			<br />
			<p class="donation"><strong>Donations?</strong> Our servers cost money which l&uuml;ffy &amp; Virtue pay for out of their own pockets. <a class="" href="/donate" title="Donate">We do accept donations</a>.</p>
		</section>
	</div>

	<div class="col-sm-12 col-md-4">

		<section class="content-shade sidebar">
			{{--<h4>Our Servers</h4>--}}
			{{--<ul id="server-status">--}}
				{{--<li data-ip="203.33.121.205" data-port="27021">--}}
					{{--<p>--}}
						{{--<a href="steam://connect/203.33.121.205:27021"><b>#1 Chill Out + Custom Maps</b></a><br>--}}
						{{--<small><i class="fa fa-users"></i> <span class="players"></span>/<span class="maxPlayers"></span> - <span class="mapName"></span></small>--}}
					{{--</p>--}}
				{{--</li>--}}
				{{--<li data-ip="203.33.121.205" data-port="27058">--}}
					{{--<p>--}}
						{{--<a href="steam://connect/203.33.121.205:27058"><b>#2 Highlander Mode</b></a><br>--}}
						{{--<small><i class="fa fa-users"></i> <span class="players"></span>/<span class="maxPlayers"></span> - <span class="mapName"></span></small>--}}
					{{--</p>--}}
				{{--</li>--}}
			{{--</ul>--}}

			<h4>Latest News</h4>
			<ul id="latest-news"></ul>

			<h4>Upcoming Events</h4>
			<ul id="upcoming-events"></ul>

			<h4>Recent Discussions</h4>
			<ul id="recent-discussions"></ul>
		</section>






	</div>

@stop

@section('footer')

	<script>

		function getUpcomingEvents(){

			$.getJSON('/get-steam-events', function (json) {

				if(json.length == 0)
				{
					$('#upcoming-events').append(
							$('<li/>').text('No upcoming events this month.')
					);

					return;
				}

				$.each(json, function (index,data) { // or "item" or whatever suits your feed

					if(index > 2){
						return false;
					}

					var li = $('<li/>').append(
							$('<span/>').text(data.date + ' - '),
							$('<a/>', {'href':data.link, 'target':'_blank'}).html(data.title + ' <small><i class="fa fa-external-link"></i></small>')
					);

					$('#upcoming-events').append(li);

				});

			});

		}

		function getlatestNews(){

			$.getJSON('/get-steam-news', function (json) {

				if(json.length == 0)
				{
					$('#latest-news').append(
							$('<li/>').text('No news is available.')
					);

					return;
				}

				$.each(json, function (index,data) { // or "item" or whatever suits your feed

					if(index > 2){
						return false;
					}

					var li = $('<li/>').append(
							$('<span/>').text(data.date + ' - '),
							$('<a/>', {'href':data.link, 'target':'_blank'}).html(data.title + ' <small><i class="fa fa-external-link"></i></small>')
					);

					$('#latest-news').append(li);

				});

			});

		}

		function getForumPosts(){

			$.getJSON('/get-steam-discussions', function (json) {

				if(json.length == 0)
				{
					$('#recent-discussions').append(
							$('<li/>').text('No discussions available.')
					);

					return;
				}

				$.each(json, function (index,data) { // or "item" or whatever suits your feed

					if(index > 2){
						return false;
					}

					var li = $('<li/>').append(
							$('<a/>', {'href':data.link, 'target':'_blank'}).html(data.topicName + ' <small><i class="fa fa-external-link"></i></small>'),
							$('<br/>'),
							$('<small/>').text(data.lastPoster + ' - ' + data.lastPostDatePretty)
					);

					$('#recent-discussions').append(li);

				});
			});

		}

		function getServerStatus() {

			$('#server-status').find('li').each(function(index) {

				var server = $(this);

				var ip = server.attr('data-ip');
				var port = server.attr('data-port');

				$.post('/get-steam-server-status', { ip: ip, port: port }, function(json){

					if(json.length == 0) {
						server.html('Offline');
					}

					json = $.parseJSON(json);

					server.find('.players').text(json.numberOfPlayers);
					server.find('.maxPlayers').text(json.maxPlayers);
					server.find('.mapName').text(json.mapName);
				});
			});

			// Refresh every minute
			setTimeout(getServerStatus, 60000);

		}

		$( document ).ready(function() {

			getForumPosts();
			getServerStatus();
			getUpcomingEvents();
			getlatestNews();

		});

	</script>

@stop