define(['sharrre'], function (jQuery) {

	function sidebarWidget ($el) {
		//$el;
		console.log('inicializa sidebarWidget');
	}

	sidebarWidget.prototype.init = function() {
		var url = "http://gdata.youtube.com/feeds/users/brasilemrede/uploads?alt=json-in-script&max-results=1";

		jQuery('.invite-facebook').on('click', function (e) {
			e.preventDefault();
			FB.ui({
				method: 'apprequests',
				message: 'Convide seus amigos para fazer parte da rede'
			});
		});

		jQuery('#twitter').sharrre({
		share: {
		twitter: true
		},
		template: '<div class="box tw"><a class="share" href="javascript:void(0);"><i class="icon-twitter"></i><span>Twitter</span></a><a class="count" href="javascript:void(0);">{total}</a></div>',
		enableHover: false,
		enableTracking: true,
		buttons: { twitter: {via: 'maisumnarede'}},
		click: function(api, options){
		api.simulateClick();
		api.openPopup('twitter');
		}
		});
		jQuery('#facebook').sharrre({
		share: {
		facebook: true
		},
		template: '<div class="box fb"><a class="share" href="javascript:void(0);"><i class="icon-facebook"></i><span>Facebook</span></a><a class="count" href="javascript:void(0);">{total}</a></div>',
		enableHover: false,
		enableTracking: true,
		click: function(api, options){
		api.simulateClick();
		api.openPopup('facebook');
		}
		});
		jQuery('#googleplus').sharrre({
		urlCurl: THEME_URL + '/assets/bower_components/Sharrre/sharrre.php',
		share: {
		googlePlus: true
		},
		template: '<div class="box gp"><a class="share" href="javascript:void(0);"><i class="icon-google-plus"></i><span>Google +</span></a><a class="count" href="javascript:void(0);">{total}</a></div>',
		enableHover: false,
		enableTracking: true,
		click: function(api, options){
		api.simulateClick();
		api.openPopup('googlePlus');
		}
		});

		jQuery.ajax({url: url, dataType: 'jsonp'})
		.done(function (data) {

			var feed = data.feed;
			var entries = feed.entry || [];
			var html = [''];
			
			for (var i = 0; i < entries.length; i++) {
				var entry = entries[i];
				var title = entry.title.$t.substr(0,25);
				var time = entry.media$group.yt$duration.seconds;
				var thumbnailUrl = entries[i].media$group.media$thumbnail[0].url;
				var playerUrl = entries[i].media$group.media$content[0].url;

				var minutes = Math.floor(time / 60);
				var seconds = time - minutes * 60;
				
				html.push('<div id="player-yb"><img src="', thumbnailUrl, '" width="276" /></div>');
			}
			
			document.getElementById('youtube-player').innerHTML = html.join('');
			//'&rel=1&border=0&fs=1&autoplay=0'
			swfobject.embedSWF(playerUrl, 'player-yb', '276', '200', '9.0.0', false, false, {allowfullscreen: 'true'});
		});
	};

	function loadVideo (playerUrl, autoplay) {
	  	
	};

	return sidebarWidget;
});