define(['jquery'], function (jQuery) {

	function redesign() {
	}

	redesign.prototype.init = function() {
	    if (jQuery('#youtube-player').length) {
    		var youtubeURL = 'http://gdata.youtube.com/feeds/users/brasilemrede/uploads?alt=json-in-script&max-results=1';
    		jQuery.ajax({
    		    url      : youtubeURL,
    		    dataType : 'jsonp'
    	    }).done(function done(data) {
    			var feed = data.feed,
    			    entries = feed.entry || [],
    			    html = [''],
    			    playerUrl;
    			for (var i = 0, s = entries.length; i < s; i++) {
    				var entry = entries[i],
    				    thumbnailUrl = entry.media$group.media$thumbnail[0].url;
    				playerUrl = entry.media$group.media$content[0].url;
    				html.push('<div id="player-yb"><img src="', thumbnailUrl, '" width="276" /></div>');
    			}
    			document.getElementById('youtube-player').innerHTML = html.join('');
    			swfobject.embedSWF(playerUrl, 'player-yb', '276', '200', '9.0.0', false, false, { allowfullscreen : 'true' });
    		});
	    }
	};

	return redesign;
});