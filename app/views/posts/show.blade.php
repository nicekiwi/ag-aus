@extends('layouts.master')

@section('content')

<style type="text/css">
	
	#nodebb *, #nodebb *:before, #nodebb *:after {
	    -webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		-ms-box-sizing: border-box;
		box-sizing: border-box;
	}

	#nodebb {
		margin-top: 50px;
		min-height: 300px;
	}
	#nodebb .well {
	    min-height: 20px;
	    padding: 24px;
	    margin-bottom: 20px;
	    background-color: #FFF;
	    border: 1px solid #EDEDED;
	    border-radius: 0px;
	    box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.05) inset;
	}
	#nodebb .topic-item {
		font-family: Roboto,Helvetica,Arial,sans-serif;
		font-size: 14px;
		line-height: 1.42857;
		color: #333;
		min-height: 75px;
		position: relative;
	}

	#nodebb .topic-body {
		padding: 10px;
		padding-bottom: 5px;
		display: inline-block;
		width: 100%;
	}

	#nodebb .topic-profile-pic {
		float: left;
		margin-left: 15px;
		margin-right: 15px;
		width: 50px;
		position: absolute;
		left: -85px;
	}

	#nodebb .user {
		left: -83px; /*why??*/
	}

	#nodebb .topic-text {
		width: 100%;
		float: left;
		font-size: 18px;
		color: #333;
		overflow: hidden;
		word-wrap: break-word;
	}

	#nodebb .topic-text blockquote {
		margin-left: 10px;
	}

	#nodebb .topic-text img {
		display: inline-block;
	}

	#nodebb .topic-text p {
		margin: 10px;
	}

	#nodebb .topic-text small {
		color: #888;
	}

	#nodebb .profile-image {
	    width: 52px;
	    height: 52px;
	    border-radius: 100%;
	    border: 1px solid #EFEFEF;
	}

	#nodebb > ul {
	    margin-bottom: 0px;
	    list-style-type: none;
	    padding: 0px;
	}

	#nodebb > ul > li {
	    border-left: 2px solid #333;
	    background-color: #FFF;
	    box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.3);
	    padding-bottom: 0px;
	    margin-bottom: 15px;
	    -webkit-transition: opacity 0.3s ease-in;
	    -moz-transition: opacity 0.3s ease-in;
	    -o-transition: opacity 0.3s ease-in;
	    -ms-transition: opacity 0.3s ease-in;
	    transition: opacity 0.3s ease-in;
	    opacity: 1;
	}

	#nodebb .form-control:focus {
	    border-color: #66AFE9;
	    outline: 0px none;
	    box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.075) inset, 0px 0px 8px rgba(102, 175, 233, 0.6);
	}

	#nodebb .form-control {
	    display: block;
	    width: 100%;
	    padding: 8px 12px;
	    font-size: 14px;
	    line-height: 1.42857;
	    color: #555;
	    vertical-align: middle;
	    background-color: #FFF;
	    background-image: none;
	    border: 1px solid #CCC;
	    border-radius: 0px;
	    box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.075) inset;
	    transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
	}

	#nodebb .btn {
		display: inline-block;
		margin-bottom: 0px;
		font-weight: normal;
		text-align: center;
		vertical-align: middle;
		cursor: pointer;
		background-image: none;
		border: 1px solid transparent;
		white-space: nowrap;
		padding: 8px 12px;
		font-size: 14px;
		line-height: 1.42857;
		border-radius: 0px;
		-moz-user-select: none;
		margin-top: 5px;
		margin-left: 5px;
	}

	#nodebb .btn:focus {
		outline: 5px auto -webkit-focus-ring-color;
		outline-offset: -2px;
	}
	#nodebb .btn:hover,
	#nodebb .btn:focus {
		color: #333333;
		text-decoration: none;
	}
	#nodebb .btn:active,
	#nodebb .btn.active {
		outline: 0;
		background-image: none;
		-webkit-box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
		box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
	}

	#nodebb .btn.btn-primary {
	    background: none repeat scroll 0% 0% #38C071;
	    color: #FFF;
	    border-radius: 3px;
	    border: 1px solid #38C071;
	    float: right;
	}

	#nodebb iframe {
		border: 0;
	}

	#nodebb .nodebb-post-fadein {
		opacity: 0;
	}

	#nodebb #nodebb-error {
		color: #dd3232;
	}

	#nodebb .nodebb-copyright {
		font-size: 14px;
	}

	#nodebb .nodebb-copyright a {
		text-decoration: none;
		color: #38C071;
	}

	#nodebb .emoji {
	    height: 20px;
	    width: 20px;
	    display: inline-block !important;
	}

</style>

<h1>{{ $post->title }}</h1>
<p>Posted by <a href="/users/{{ $post->user->username }}">{{ $post->user->username }}</a> {{ $post->created_at->diffForHumans() }}</p>
{{ $post->desc }}

<a href="/posts/{{ $post->id }}/edit">Edit post</a>




<a id="nodebb/comments"></a>
<script type="text/javascript">
var nodeBBURL = 'https://community.ag-aus.org',
    articleID = '{{ $post->id }}';

var addComments = function()
{



};

(function() {
	"use strict";
	
	var articlePath = window.location.protocol + '//' + window.location.host + window.location.pathname;

	var pluginURL = nodeBBURL + '/plugins/nodebb-plugin-blog-comments',
		savedText, nodebbDiv, contentDiv, commentsDiv, commentsCounter;

	// var stylesheet = document.createElement("link");
	// stylesheet.setAttribute("rel", "stylesheet");
	// stylesheet.setAttribute("type", "text/css");
	// stylesheet.setAttribute("href", pluginURL + '/css/comments.css');

	// document.getElementsByTagName("head")[0].appendChild(stylesheet);
	document.getElementById('nodebb/comments').insertAdjacentHTML('beforebegin', '<div id="nodebb"></div>');
	nodebbDiv = document.getElementById('nodebb');

	function newXHR() {
		try {
	        return XHR = new XMLHttpRequest();
	    } catch (e) {
	        try {
	            return XHR = new ActiveXObject("Microsoft.XMLHTTP");
	        } catch (e) {
	            return XHR = new ActiveXObject("Msxml2.XMLHTTP");
	        }
	    }
	}

	var XHR = newXHR(), pagination = 0, modal;

	function authenticate(type) {
		savedText = contentDiv.value;
		modal = window.open(nodeBBURL + "/" + type + "/#blog/authenticate","_blank","toolbar=no, scrollbars=no, resizable=no, width=600, height=675");
		var timer = setInterval(function() {
			if(modal.closed) {  
				clearInterval(timer);
				pagination = 0;
				reloadComments();
			}  
		}, 500);
	}

	function normalizePost(post) {
		return post.replace(/href="\/(?=\w)/g, 'href="' + nodeBBURL + '/')
				.replace(/src="\/(?=\w)/g, 'src="' + nodeBBURL + '/');
	}

	XHR.onload = function() {
		if (XHR.status >= 200 && XHR.status < 400) {
			var data = JSON.parse(XHR.responseText), html;

			commentsDiv = document.getElementById('nodebb-comments-list');
			commentsCounter = document.getElementById('nodebb-comments-count');

			data.relative_path = nodeBBURL;
			data.redirect_url = articlePath;
			data.article_id = articleID;
			data.pagination = pagination;
			data.postCount = parseInt(data.postCount, 10);

			for (var post in data.posts) {
				if (data.posts.hasOwnProperty(post)) {
					data.posts[post].timestamp = timeAgo(parseInt(data.posts[post].timestamp), 10);
					if (data.posts[post]['blog-comments:url']) {
						delete data.posts[post];
					}
				}
			}
			
			if (commentsCounter) {
				commentsCounter.innerHTML = data.postCount ? (data.postCount - 1) : 0;
			}

			if (pagination) {
				html = normalizePost(parse(data, templates.blocks['posts']));
				commentsDiv.innerHTML = commentsDiv.innerHTML + html;	
			} else {
				html = parse(data, data.template);
				nodebbDiv.innerHTML = normalizePost(html);
			}

			contentDiv = document.getElementById('nodebb-content');

			setTimeout(function() {
				var lists = nodebbDiv.getElementsByTagName("li");
				for (var list in lists) {
					if (lists.hasOwnProperty(list)) {
						lists[list].className = '';
					}
				}
			}, 100);
			
			if (savedText) {
				contentDiv.value = savedText;
			}

			if (data.tid) {
				var loadMore = document.getElementById('nodebb-load-more');
				loadMore.onclick = function() {
					pagination++;
					reloadComments();
				}
				if (data.posts.length) {
					loadMore.style.display = 'inline-block';	
				}

				if (pagination * 10 + data.posts.length + 1 >= data.postCount) {
					loadMore.style.display = 'none';
				}

				if (typeof jQuery !== 'undefined' && jQuery() && jQuery().fitVids) {
					jQuery(nodebbDiv).fitVids();
				}

				if (data.user && data.user.uid) {
					var error = window.location.href.match(/error=[\w-]*/);
					if (error) {
						error = error[0].split('=')[1];
						if (error === 'too-many-posts') {
							error = 'Please wait before posting so soon.';
						} else if (error === 'content-too-short') {
							error = 'Please post a longer reply.';
						}

						document.getElementById('nodebb-error').innerHTML = error;
					}					
				} else {
					document.getElementById('nodebb-register').onclick = function() {
						authenticate('register');
					};

					document.getElementById('nodebb-login').onclick = function() {
						authenticate('login');
					}
				}
			} else {
				if (data.isAdmin) {
					var adminXHR = newXHR();
					adminXHR.open('GET', '/news/json/' + articleID);
					adminXHR.onload = function() {
						if (adminXHR.status >= 200 && adminXHR.status < 400) {
							var articleData = JSON.parse(adminXHR.responseText),
								translator = document.createElement('span');

							translator.innerHTML = articleData.desc;

							var markdown = translator.innerHTML + '\n\n**Click [here]('+articlePath+') to see the full blog post**';

							document.getElementById('nodebb-content-markdown').value = markdown;
							document.getElementById('nodebb-content-title').value = articleData.title;
							document.getElementById('nodebb-content-tags').value = articleData.tags;
						} else {
							console.warn('Unable to access API. Please install the JSON API plugin located at: http://wordpress.org/plugins/json-api');
						}
					}

					adminXHR.send();
				}
			}
		}
	};

	function reloadComments() {
		XHR.open('GET', nodeBBURL + '/comments/get/' + articleID + '/' + pagination, true);
		XHR.withCredentials = true;
		XHR.send();
	}

	reloadComments();


	function timeAgo(time){
		var time_formats = [
			[60, 'seconds', 1],
			[120, '1 minute ago'],
			[3600, 'minutes', 60],
			[7200, '1 hour ago'],
			[86400, 'hours', 3600],
			[172800, 'yesterday'],
			[604800, 'days', 86400],
			[1209600, 'last week'],
			[2419200, 'weeks', 604800],
			[4838400, 'last month'],
			[29030400, 'months', 2419200],
			[58060800, 'last year'],
			[2903040000, 'years', 29030400]
		];

		var seconds = (+new Date() - time) / 1000;

		if (seconds < 10) {
			return 'just now';
		}
		
		var i = 0, format;
		while (format = time_formats[i++]) {
			if (seconds < format[0]) {
				if (!format[2]) {
					return format[1];
				} else {
					return Math.floor(seconds / format[2]) + ' ' + format[1] + ' ago';
				}
			}
		}
		return time;
	}

	var templates = {blocks: {}};
	function parse (data, template) {
		function replace(key, value, template) {
			var searchRegex = new RegExp('{' + key + '}', 'g');
			return template.replace(searchRegex, value);
		}

		function makeRegex(block) {
			return new RegExp("<!--[\\s]*BEGIN " + block + "[\\s]*-->[\\s\\S]*<!--[\\s]*END " + block + "[\\s]*-->", 'g');
		}

		function makeConditionalRegex(block) {
			return new RegExp("<!--[\\s]*IF " + block + "[\\s]*-->([\\s\\S]*?)<!--[\\s]*ENDIF " + block + "[\\s]*-->", 'g');
		}

		function getBlock(regex, block, template) {
			data = template.match(regex);
			if (data == null) return;

			if (block !== undefined) templates.blocks[block] = data[0];

			var begin = new RegExp("(\r\n)*<!-- BEGIN " + block + " -->(\r\n)*", "g"),
				end = new RegExp("(\r\n)*<!-- END " + block + " -->(\r\n)*", "g"),

			data = data[0]
				.replace(begin, "")
				.replace(end, "");

			return data;
		}

		function setBlock(regex, block, template) {
			return template.replace(regex, block);
		}

		var regex, block;

		return (function parse(data, namespace, template, blockInfo) {
			if (!data || data.length == 0) {
				template = '';
			}

			function checkConditional(key, value) {
				var conditional = makeConditionalRegex(key),
					matches = template.match(conditional);

				if (matches !== null) {
					for (var i = 0, ii = matches.length; i < ii; i++) {
						var conditionalBlock = matches[i].split(/<!-- ELSE -->/);

						var statement = new RegExp("(<!--[\\s]*IF " + key + "[\\s]*-->)|(<!--[\\s]*ENDIF " + key + "[\\s]*-->)", 'gi');

						if (conditionalBlock[1]) {
							// there is an else statement
							if (!value) {
								template = template.replace(matches[i], conditionalBlock[1].replace(statement, ''));
							} else {
								template = template.replace(matches[i], conditionalBlock[0].replace(statement, ''));
							}
						} else {
							// regular if statement
							if (!value) {
								template = template.replace(matches[i], '');
							} else {
								template = template.replace(matches[i], matches[i].replace(statement, ''));
							}
						}
					}
				}
			}

			for (var d in data) {
				if (data.hasOwnProperty(d)) {
					if (typeof data[d] === 'undefined') {
						continue;
					} else if (data[d] === null) {
						template = replace(namespace + d, '', template);
					} else if (data[d].constructor == Array) {
						checkConditional(namespace + d + '.length', data[d].length);
						checkConditional('!' + namespace + d + '.length', !data[d].length);

						namespace += d + '.';

						var regex = makeRegex(d),
							block = getBlock(regex, namespace.substring(0, namespace.length - 1), template);

						if (block == null) {
							namespace = namespace.replace(d + '.', '');
							continue;
						}

						var numblocks = data[d].length - 1,
							i = 0,
							result = "";

						do {
							result += parse(data[d][i], namespace, block, {iterator: i, total: numblocks});
						} while (i++ < numblocks);

						namespace = namespace.replace(d + '.', '');
						template = setBlock(regex, result, template);
					} else if (data[d] instanceof Object) {
						template = parse(data[d], d + '.', template);
					} else {
						var key = namespace + d,
							value = typeof data[d] === 'string' ? data[d].replace(/^\s+|\s+$/g, '') : data[d];

						checkConditional(key, value);
						checkConditional('!' + key, !value);

						if (blockInfo && blockInfo.iterator) {
							checkConditional('@first', blockInfo.iterator === 0);
							checkConditional('!@first', blockInfo.iterator !== 0);
							checkConditional('@last', blockInfo.iterator === blockInfo.total);
							checkConditional('!@last', blockInfo.iterator !== blockInfo.total);
						}

						template = replace(key, value, template);
					}
				}
			}

			if (namespace) {
				var regex = new RegExp("{" + namespace + "[\\s\\S]*?}", 'g');
				template = template.replace(regex, '');
				namespace = '';
			} else {
				// clean up all undefined conditionals
				template = template.replace(/<!-- ELSE -->/gi, 'ENDIF -->')
									.replace(/<!-- IF([^@]*?)ENDIF([^@]*?)-->/gi, '');
			}

			return template;

		})(data, "", template);
	}
}());
</script>
<noscript>Please enable JavaScript to view comments</noscript>


@stop