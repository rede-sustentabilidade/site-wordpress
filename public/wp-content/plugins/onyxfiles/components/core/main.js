/**
 * Created by jaskokoyn on 5/7/2015.
 */
jQuery(function($){
    soundManager.setup({
        // trade-off: higher UI responsiveness (play/progress bar), but may use more CPU.
        html5PollingInterval: 50,
        flashVersion: 9
    });

    var currentTrack    =   null;

    if($(".jkof_file_center_placeholder").length){
        $.post(jkof_ajax_url, { action: 'jkof_get_file_center_files' }, function(response){
            try{
                var jsonRes         =   JSON.parse(response);
            }catch(e){
                console.log(e);
                return null;
            }

            $(".jkof_file_center_placeholder").html('');

            jsonRes.shared_files.forEach(function(ele,ind,arr){
                $(".jkof_file_center_placeholder").append(
                    '<div class="jkof_single_file text-center col-md-4">' +
                    '<i class="fa fa-file-text-o fa-4x"></i>' +
                    '<strong>' + ele.title  + '</strong><br>' +
                    '<small><em>(' + ele.size + ')</em></small><br>' +
                    '<button type="button" data-fid="' + ele.id + '" data-file-share="1" data-target="#jkof-dl-modal" class="jkof_openDLModalBtn btn btn-success">Download File</button>' +
                    '</div>'
                );
            });
        });
    }

    $(document).on( 'click', '#jkof_openPlayerMenu', function(e){
        e.preventDefault();
        $(".sm2-playlist-drawer").css( 'opacity', 0.9 );

        if($(".sm2-playlist-drawer").height()){
            $(".sm2-playlist-drawer").height(0);
        }else{
            $(".sm2-playlist-drawer").height(150);
        }
    });

    $(document).on( 'click', '.play-pause', function(e){
        e.preventDefault();
        $(".sm2-bar-ui").toggleClass('playing paused');
        if(currentTrack){
            currentTrack.togglePause();
            return null;
        }

        var trackURL        =   encodeURI($(".sm2-playlist-bd > li.selected > a").attr('href'));
        console.log(trackURL);
        currentTrack    =   soundManager.createSound({
            url: trackURL,
            volume: 100,
            whileplaying: function() {
                if (this.duration) {
                    var progressMaxLeft = 100,
                        left,
                        width;

                    left = Math.min(progressMaxLeft, Math.max(0, (progressMaxLeft * (this.position / this.durationEstimate)))) + '%';
                    width = Math.min(100, Math.max(0, (100 * this.position / this.durationEstimate))) + '%';

                    $('.sm2-progress-ball').css('left', left);
                    $('.sm2-progress-bar').css('width', width);

                    // TODO: only write changes
                    $('.sm2-inline-time').text( getTime(this.position, true) );
                }
            },
            onbufferchange: function(isBuffering) {
                if (isBuffering) {
                    $(".sm2-bar-ui").addClass('buffering');
                } else {
                    $(".sm2-bar-ui").removeClass('buffering');
                }
            },
            whileloading: function() {
                if (!this.isHTML5) {
                    $(".sm2-inline-duration").text( getTime(this.durationEstimate, true) );
                }
            },
            onload: function(ok) {
                if (ok) {
                    $(".sm2-inline-duration").text( getTime(this.duration, true) );
                }
            },
            onfinish: function() {
                $('.sm2-progress-ball').css('left', 0);
                $('.sm2-progress-bar').css('width', 0);

                // TODO: only write changes
                $('.sm2-inline-time').text( '0:00' );
                currentTrack.destruct();
                currentTrack    =   null;
            }
        });

        currentTrack.play();
    });

    $(document).on( 'click', '.sm2-playlist-bd > li > a', function(e){
        e.preventDefault();
        $(".sm2-playlist-bd > li").removeClass('selected');
        $(this).parent().addClass('selected');
        $(".sm2-playlist-target").text( $(this).text() );

        if(currentTrack){
            $('.sm2-progress-ball').css('left', 0);
            $('.sm2-progress-bar').css('width', 0);
            $('.sm2-inline-time').text( '0:00' );
            $('.sm2-inline-duration').text( '0:00' );
            $(".sm2-bar-ui").addClass('paused');
            $(".sm2-bar-ui").removeClass('playing');
            currentTrack.destruct();
            currentTrack    =   null;
            $( ".play-pause" ).trigger( "click" );
        }
    });

    $(document).on( 'click', '.sm2-inline-button.previous', function(e){
        e.preventDefault();
        var prevElem            =   $(".sm2-playlist-bd > li.selected").prev();

        if(!prevElem.length){
            return null;
        }

        $(".sm2-playlist-bd > li").removeClass('selected');
        prevElem.addClass('selected');
        $(".sm2-playlist-target").text( prevElem.find('a').text() );

        if(currentTrack){
            $('.sm2-progress-ball').css('left', 0);
            $('.sm2-progress-bar').css('width', 0);
            $('.sm2-inline-time').text( '0:00' );
            $('.sm2-inline-duration').text( '0:00' );
            $(".sm2-bar-ui").addClass('paused');
            $(".sm2-bar-ui").removeClass('playing');
            currentTrack.destruct();
            currentTrack    =   null;
            $( ".play-pause" ).trigger( "click" );
        }
    });

    $(document).on( 'click', '.sm2-inline-button.next', function(e){
        e.preventDefault();
        var nextElem            =   $(".sm2-playlist-bd > li.selected").next();

        if(!nextElem.length){
            return null;
        }

        $(".sm2-playlist-bd > li").removeClass('selected');
        nextElem.addClass('selected');
        $(".sm2-playlist-target").text( nextElem.find('a').text() );

        if(currentTrack){
            $('.sm2-progress-ball').css('left', 0);
            $('.sm2-progress-bar').css('width', 0);
            $('.sm2-inline-time').text( '0:00' );
            $('.sm2-inline-duration').text( '0:00' );
            $(".sm2-bar-ui").addClass('paused');
            $(".sm2-bar-ui").removeClass('playing');
            currentTrack.destruct();
            currentTrack    =   null;
            $( ".play-pause" ).trigger( "click" );
        }
    });

    function getTime(msec, useString) {
        // convert milliseconds to hh:mm:ss, return as object literal or string
        var nSec = Math.floor(msec/1000),
            hh = Math.floor(nSec/3600),
            min = Math.floor(nSec/60) - Math.floor(hh * 60),
            sec = Math.floor(nSec -(hh*3600) -(min*60));

        // if (min === 0 && sec === 0) return null; // return 0:00 as null
        return (useString ? ((hh ? hh + ':' : '') + (hh && min < 10 ? '0' + min : min) + ':' + ( sec < 10 ? '0' + sec : sec ) ) : { 'min': min, 'sec': sec });
    }
});