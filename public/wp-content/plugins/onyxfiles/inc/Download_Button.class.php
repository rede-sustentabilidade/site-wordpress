<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 4/30/2015
 * Time: 2:57 PM
 */

Class JKOF_Download_Btn{
    private $btn_settings;
    private $btn                    =   '';
    public static $colors           =   array(
        'rcw-green' => 'Green', 'rcw-blue' => 'Blue', 'rcw-red' => 'Red',
        'rcw-orange' => 'Orange', 'rcw-purple' => 'Purple', 'rcw-midnightblue' => 'Midnight Blue',
        'rcw-turquoise' => 'Turquoise', 'rcw-emerald' => 'Emerald', 'rcw-wetasphalt' => 'Wet Asphalt',
        'rcw-greensea' => 'Green Sea', 'rcw-nephritis' => 'Nephritis', 'rcw-belizehole' => 'Belize Hole',
        'rcw-sunflower' => 'Sunflower', 'rcw-carrot' => 'Carrot', 'rcw-alizarin' => 'Alizarin',
        'rcw-clouds' => 'Clouds', 'rcw-concrete' => 'Concrete', 'rcw-pumpkin' => 'Pumpkin',
        'rcw-pomegranate' => 'Pomegranate', 'rcw-silver' => 'Silver', 'rcw-youtube' => 'Youtube',
        'rcw-asbestos' => 'Asbestos', 'rcw-facebook' => 'Facebook', 'rcw-twitter' => 'Twitter',
        'rcw-github' => 'Github', 'rcw-linkedin' => 'Linkedin', 'rcw-rss' => 'RSS',
        'rcw-googleplus' => 'Google Plus', 'rcw-dribbble' => 'Dribbble', 'rcw-flickr' => 'Flickr',
        'rcw-html5' => 'HTML5', 'rcw-pinterest' => 'Pinterest', 'rcw-stackoverflow' => 'Stack Overflow',
        'rcw-weibo' => 'Weibo', 'rcw-android' => 'Android', 'rcw-dropbox' => 'Dropbox',
        'rcw-foursquare' => 'Foursquare', 'rcw-instagram' => 'Instagram', 'rcw-renren' => 'Renren',
        'rcw-windows' => 'Windows', 'rcw-apple' => 'Apple', 'rcw-skype' => 'Skype',
        'rcw-tumblr' => 'Tumblr', 'rcw-vimeo' => 'Vimeo', 'rcw-xing' => 'Xing',
        'rcw-css3' => 'CSS3', 'rcw-vk' => 'VK', 'rcw-flattr' => 'Flattr',
        'rcw-paypal' => 'Paypal', 'rcw-yelp' => 'Yelp', 'rcw-lastfm' => 'LastFm',
        'rcw-stumbleupon' => 'StumbleUpon', 'rcw-wordpress' => 'WordPress', 'rcw-joomla' => 'Joomla',
        'rcw-blogger' => 'Blogger', 'rcw-soundcloud' => 'Soundcloud', 'rcw-chrome' => 'Chrome',
        'rcw-firefox' => 'FireFox', 'rcw-ie' => 'Internet Explorer', 'rcw-opera' => 'Opera',
        'rcw-safari' => 'Safari', 'rcw-icomoon' => 'Icomoon', 'rcw-lanyrd' => 'Lanyrd',
        'rcw-deviantart' => 'Deviant Art', 'rcw-forrst' => 'Forrst', 'rcw-yahoo' => 'Yahoo',
        'rcw-steam' => 'Steam', 'rcw-reddit' => 'Reddit', 'rcw-picasa' => 'Picasa',
        'rcw-delicious' => 'Delicious', 'rcw-behance' => 'Behance', 'rcw-mixi' => 'Mixi',
        'rcw-smashing' => 'Smashing', 'rcw-evernote' => 'Evernote'
    );
    public static $sizes            =   array( 'rcw-large' => 'Large', 'rcw-medium' => 'Medium', 'rcw-small' => 'Small' );
    public static $effects          =   array(
        'rcw-grow' => "grow", 'rcw-shrink' => "shrink", 'rcw-rotate' => "rotate",
        'rcw-icon-out-in' => "icon out in", 'rcw-icon-shrink' => "icon shrink", 'rcw-sink' => "sink",
        'rcw-skew' => "skew", 'rcw-skew-forward' => "skew forward", 'rcw-border-fade' => "border fade",
        'rcw-hollow' => "hollow", 'rcw-box-shadow-br' => "box shadow br", 'rcw-float-shadow' => "float shadow",
        'rcw-curl-stop-left' => "curl top left", 'rcw-curl-top-right' => "curl top right", 'rcw-curl-bottom-right' => "curl bottom right",
        'rcw-wobble-horizontal' => "wobble horizontal", 'rcw-wobble-verticle' => "wobble vertical", 'rcw-wobble-top' => "wobble top",
        'rcw-wobble-bottom' => "wobble bottom", 'rcw-push' => "push", 'rcw-pop' => "pop",
        'rcw-bounce' => "bounce", 'rcw-flash' => "flash", 'rcw-pulse' => "pulse",
        'rcw-pulse-grow' => "pulse grow", 'rcw-pulse-shrink' => "pulse shrink", 'rcw-rubber-hand' => "rubber band",
        'rcw-swing' => "swing", 'rcw-tada' => "tada", 'rcw-icon-grow' => "icon grow", 'rcw-icon-rotate' => "icon rotate"
    );
    public static $enhancements     =   array(
        'add-highlight' => "highlight", 'add-highlight-2' => "highlight 2",
        'add-highlight-3' => "highlight 3", 'add-gradient-highlight' => "gradient highlight",
        'add-gradient' => "gradient", 'add-gradient-2' => "gradient 2", 'add-inner-highlight' => "inner highlight",
        'add-border' => "border", 'add-box-shadow' => "box shadow"
    );
    public static $shapes           =   array(
        'rcw-rounded' => "rounded", 'rcw-pill' => "pill", 'rcw-rounded-top' => "rounded top",
        'rcw-rounded-bottom' => "rounded bottom", 'rcw-rounded-right' => "rounded right",
        'rcw-rounded-left' => "rounded left", 'rcw-rounded-diagonal' => "rounded diagonal 1",
        'rcw-rounded-diagonal-2' => "rounded diagonal 2", 'rcw-rounded-top-left' => "rounded top left",
        'rcw-rounded-top-right' => "rounded top right", 'rcw-rounded-bottom-right' => "rounded bottom right",
        'rcw-rounded-bottom-left' => "rounded bottom left", 'rcw-rounded-3corners-1' => "rounded 3corners 1",
        'rcw-rounded-3corners-2' => "rounded 3corners 2", 'rcw-rounded-3corners-3' => "rounded 3corners 3",
        'rcw-rounded-3corners-4' => "rounded 3corners 4"
    );
    public static $styles           =   array(
        'rcw-button-0' => 'Style 1', 'rcw-button-1' => 'Style 2', 'rcw-button-2' => 'Style 3',
        'rcw-button-3' => 'Style 4', 'rcw-button-4' => 'Style 5', 'rcw-button-5' => 'Style 6',
        'rcw-button-6' => 'Style 7', 'rcw-button-7' => 'Style 8'
    );
    private $icons                  =   array();

    public function __construct($settings){
        $this->btn_settings         =   $settings;
        $this->icons                =   smk_font_awesome();
    }

    public function build($isExample = false, $id = 0, $isBlock = false){
        $btn_class                  =   '';
        $inner_btn                  =   '';
        $btn_id                     =   '';

        $btn_class                  .=  $this->btn_settings['style'] . ' ';
        $btn_class                  .=  $this->btn_settings['size'] . ' ';
        $btn_class                  .=  $this->btn_settings['color'] . ' ';
        $btn_class                  .=  $this->btn_settings['effect'] . ' ';
        $btn_class                  .=  $this->btn_settings['enhancement'] . ' ';
        $btn_class                  .=  $this->btn_settings['shape'] . ' ';
        $btn_class                  .=  $isBlock ? 'btn-block text-center ' : ' ';

        if(empty($this->btn_settings['label'])){
            $btn_class              .=  'no-text ';
        }

        if($this->btn_settings['style'] == 'rcw-button-1' || $this->btn_settings['style'] == 'rcw-button-2' || $this->btn_settings['style'] == 'rcw-button-3'){
            $inner_btn              .=  '<span class="button-icon ' . $this->btn_settings['icon'] . '"></span> ';

        }else if( $this->btn_settings['style'] == 'rcw-button-4' || $this->btn_settings['style'] == 'rcw-button-5' ||
            $this->btn_settings['style'] == 'rcw-button-6' || $this->btn_settings['style'] == 'rcw-button-7' ){
            $inner_btn              .=  '<span class="icon-bg"></span> <span class="button-icon ' . $this->btn_settings['icon'] . '"></span> ';
        }

        if($isExample){
            $btn_id                 =   'id="jkof-ex-dl-btn"';
        }

        $inner_btn                  .=  $this->btn_settings['label'];

        // Get Locks
        $file_locks       =    is_array($this->btn_settings['lock_opts']) ? $this->btn_settings['lock_opts'] : json_decode($this->btn_settings['lock_opts']);

        // Check if any locks are set
        if(empty($file_locks) && $this->btn_settings['indiv_dls'] == 1 && !$isExample){
            $fileURL        =   $this->btn_settings['files'][0]->isDirect == 2 ? $this->btn_settings['files'][0]->direct_url : "?ofdl=". $id;
            $this->btn      =   '<a href="' . $fileURL . '" class="' . $btn_class . '" ' . $btn_id . '>' . $inner_btn . '</a>';
            return true;
        }

        $li_mess          =    empty($this->btn_settings["lock_li_m"]) ? "Download File!" : $this->btn_settings["lock_li_m"];
        $li_url           =    $this->btn_settings["lock_li_url"];
        $twitter_username =    $this->btn_settings['lock_twitter_u'];
        $tweet            =    empty($this->btn_settings["lock_tweet_m"]) ? "Download File!" : $this->btn_settings["lock_tweet_m"];
        $gplus_url        =    $this->btn_settings["lock_gplus_url"];
        $fb_like_url      =    $this->btn_settings['lock_fb_like_url'];
        $fb_share_url     =    $this->btn_settings['lock_fb_share_url'];

        $this->btn        =     '<button type="button" data-target="#jkof-dl-modal"
                                    data-gplus-url="' . $gplus_url . '"
                                    data-fid="' . $id . '" data-li-message="' . $li_mess . '"
                                    data-li-url="' . $li_url . '" data-tweet="'.  $tweet . '"
                                    data-item-name="' . get_the_title( $this->btn_settings['pid'] ) . '"
                                    data-pp-amount="' . $this->btn_settings['lock_pp_amount']  . '"
                                    data-locks="' . implode(",",$file_locks) . '"
                                    data-fb-share-url="' . $fb_share_url .  '" data-fb-like-url="' . $fb_like_url . '"
                                    data-twitter-username="' . $twitter_username . '"
                                    data-allow-idl="' . $file_settings['indiv_dls'] . '"
                                    class="jkof_openDLModalBtn ' . $btn_class . '" ' . $btn_id . '>' . $inner_btn . '</button>';

        return true;
    }

    public function display_btn(){
        return $this->btn;
    }
}