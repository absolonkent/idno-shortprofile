<?php
    if (!empty($vars['user']->profile['url']) && is_array($vars['user']->profile['url'])) {
        foreach($vars['user']->profile['url'] as $url) {
            if (!empty($url)) {

                $h_card = 'u-url';

                // Quick shim for Twitter usernames
                if ($url[0] == '@') {
                    if (preg_match("/\@[a-z0-9_]+/i", $url)) {
                        $url = str_replace('@','',$url);
                        $url = 'https://twitter.com/' . $url;
                    }          
                }

                $url = $this->fixURL($url);
                $url_display = rtrim($url, '/');
                
                // Fixed: end() requires a variable, cannot be used directly on explode()
                $url_parts = explode('/', $url_display);
                $url_filtered = end($url_parts);

                // Pick appropriate icon
                $host = parse_url($url, PHP_URL_HOST);
                $host = str_replace('www.','',$host);
                
                switch($host) {
                    case 'twitter.com':
                        $icon = 'fa fa-twitter';
                        break;
                    case 'github.com':
                        $icon = 'fa fa-github';
                        break;
                    case 'fb.com':
                    case 'facebook.com':
                        $icon = 'fa fa-facebook';
                        break;
                    case 'plus.google.com':
                        $icon = 'fa fa-google-plus';
                        $url_filtered = preg_replace('/plus.google.com\//','',$url_display);
                        $url_filtered = preg_replace('/\/about$/','',$url_filtered);
                        $url_filtered = preg_replace('/^\+/','', $url_filtered);
                        break;
                    case 'linkedin.com':
                        $icon = 'fa fa-linkedin';
                        break;
                    case 'instagram.com':
                        $icon = 'fa fa-instagram';
                        break;
                    case 'untappd.com':
                        $icon = 'fa fa-beer';
                        break;
                    case 'xing.com':
                        $icon = 'fa fa-xing';
                        break;
                    case 'last.fm':
                        $icon = 'fa fa-lastfm';
                        break;
                    case 'keybase.io':
                        $icon = 'fa fa-key';
                        break;
                    case 'about.me':
                        $icon = 'fa fa-user';
                        break;
                    case 'cash.app':
                        $icon = 'fa fa-money';
                        break;
                    case 'flipboard.com':
                        $icon = 'fa fa-clipboard';
                        break;
                    case 'bandcamp.com':
                        $icon = 'fa fa-bandcamp';
                        break;
                    case 'paypal.me':
                        $icon = 'fa fa-paypal';
                        $url_filtered = preg_replace('/(?:www\.)?paypal.me\/(\w*).*/','$1',$url_display);
                        break;
                    case 'paypal.com':
                        $icon = 'fa fa-paypal';
                        $url_filtered = preg_replace('/(?:www\.)?paypal.com\/(\w*).*/','$1',$url_display);
                        break;
                    case 'pinboard.in':
                        $icon = 'fa fa-bookmark';
                        $url_filtered = str_replace('pinboard.in/u:','',$url_display);
                        $url_filtered = preg_replace('/\/public$/','',$url_filtered);
                        break;
                    case (preg_match('/.*foursquare\.com/', $host) ? true : false):
                        $icon = 'fa fa-foursquare';
                        break;
                    case (preg_match('/.*newsblur\.com/', $host) ? true : false):
                        $icon = 'fa fa-newspaper';
                        $url_filtered = str_replace('.newsblur.com','',$url_display);
                        break;
                    case (preg_match('/.*ghost\.io/', $host) ? true : false):
                        $icon = 'fa fa-snapchat-ghost';
                        $url_filtered = str_replace('.ghost.io','',$url_display);
                        break;
                    case 'flickr.com':
                        $icon = 'fa fa-flickr';
                        $url_filtered = preg_replace('/(?:www\.)?flickr.com\/photos\/(\w*).*/','$1',$url_display);
                        break;
                    case 'unsplash.com':
                        $icon = 'fa fa-image';
                        break;
                    case 'strava.com':
                        $icon = 'fa fa-strava';
                        $url_filtered = preg_replace('/(?:www\.)?strava.com\/athletes\/(\w*).*/','$1',$url_display);
                        break;
                    case 'leanpub.com':
                        $icon = 'fa fa-leanpub';
                        $url_filtered = preg_replace('/leanpub.com\/u\/(\w*).*/','$1',$url_display);
                        break;
                    case 'goodreads.com':
                        $icon = 'fa fa-book';
                        break;
                    case 'telegram.me':
                        $icon = 'fa fa-telegram';
                        break;
                    case 'threads.net':
                        $icon = 'fa fa-instagram';
                        break;
                    case 'zotero.org':
                        $icon = 'fa fa-bookmark';
                        break;
                    case 'linktr.ee':
                        $icon = 'fa fa-book';
                        break;
                    case 'reddit.com':
                        $icon = 'fa fa-reddit';
                        $url_filtered = preg_replace('/(?:www\.)?reddit.com\/user\/(\w*).*/','$1',$url_display);
                        break;
                    case 'soundcloud.com':
                        $icon = 'fa fa-soundcloud';
                        break;
                    case 'medium.com':
                        $icon = 'fa fa-medium';
                        break;
                    case 'vimeo.com':
                        $icon = 'fa fa-vimeo';
                        break;
                    case '500px.com':
                        $icon = 'fa fa-500px';
                        break;
                    case 'youtube.com':
                        $icon = 'fa fa-youtube';
                        $url_filtered = preg_replace('/(?:www\.)?youtube.com\/user\/(\w*).*/','$1',$url_display);
                        break;
                    case 'snapchat.com':
                        $icon = 'fa fa-snapchat';
                        $url_filtered = preg_replace('/(?:www\.)?snapchat.com\/add\/(\w*).*/','$1',$url_display);
                        break;
                    case 'bible.com':
                        $icon = 'fa fa-book';
                        $url_filtered = preg_replace('/(?:www\.)?bible.com\/users\/(\w*).*/','$1',$url_display);
                        break;
                    case (preg_match('/.*bible\.com/', $host) ? true : false):
                        $icon = 'fa fa-book';
                        $url_filtered = str_replace('my.bible.com/users/','',$url_display);
                        break;
                    case 'anchor.fm':
                        $icon = 'fa fa-anchor';
                        break;
                    case 'pinterest.com':
                        $icon = 'fa fa-pinterest';
                        break;
                    case (preg_match('/.*wordpress\.com/', $host) ? true : false):
                        $icon = 'fa fa-wordpress';
                        $url_filtered = str_replace('.wordpress.com','',$url_display);
                        break;
                    case 'tumblr.com':
                        $icon = 'fa fa-tumblr';
                        break;
                    case 'gitshowcase.com':
                        $icon = 'fa fa-github';
                        break;
                    case 'behance.net':
                        $icon = 'fa fa-behance';
                        break;
                    case 'micro.blog':
                        $icon = 'fa fa-rss';
                        break;
                    case 'cash.me':
                        $icon = 'fa fa-money-bill';
                        break;
                    case 'venmo.com':
                        $icon = 'fa fa-money';
                        break;
                    case (preg_match('/.*bsky\.social/', $host) ? true : false):
                        $icon = 'fa-brands fa-bluesky';
                        $url_filtered = str_replace('.bsky.social','',$url_display);
                        break;
                    case 'bsky.app':
                        $icon = 'fa fa-link';
                        break;
                    case 'upcoming.org':
                        $icon = 'fa fa-calendar-day';
                        break;
                    case 'periscope.tv':
                        $icon = 'fa fa-periscope';
                        break;
                    case 'ello.co':
                        $icon = 'fa fa-ello';
                        break;
                    case 'vine.co':
                        $icon = 'fa fa-vine';
                        break;
                    case 'producthunt.com':
                        $icon = 'fa fa-product-hunt';
                        break;
                    case 'del.icio.us':
                        $icon = 'fa fa-delicious';
                        break;
                    case 'codepen.io':
                        $icon = 'fa fa-codepen';
                        break;
                    case 'mixcloud.com':
                        $icon = 'fa fa-mixcloud';
                        break;
                    case 'stackoverflow.com':
                        $icon = 'fa fa-stack-overflow';
                        break;
                    case 'twitch.tv':
                        $icon = 'fa fa-twitch';
                        break;
                    case 'radio3.io':
                        $icon = 'fa fa-thumbs-up';
                        break;
                    case 'calendly.com':
                        $icon = 'fa fa-calendar-plus-o';
                        break;
                    case 'patch.com':
                        $icon = 'fa fa-newspaper';
                        break;
                    case 'blipfoto.com':
                        $icon = 'fa fa-photo';
                        break;
                    case 'scorestream.com':
                        $icon = 'fa fa-futbol-o';
                        break;
                    case 'vero.co':
                        $icon = 'fa fa-keyboard';
                        break;
                    case (preg_match('/.*spotify\.com/', $host) ? true : false):
                        $icon = 'fa fa-spotify';
                        // Fixed: Missing quote and parenthesis from original code
                        $url_filtered = str_replace('http://googleusercontent.com/spotify.com/', '', $url_display);
                        break;     
                    case (preg_match('/.*libib\.com/', $host) ? true : false):
                        $icon = 'fa fa-book';
                        $url_filtered = str_replace('.libib.com','',$url_display);
                        break;
                    case 'gram.social':
                        $icon = 'fa fa-camera';
                        $path = trim(parse_url($url, PHP_URL_PATH), '/');
                        // Removes internal path and converts your ID to username
                        $url_filtered = str_replace('i/web/profile/', '', $path);
                        if ($url_filtered == '785893275591103198') {
                            $url_filtered = 'absolonkent';
                        }
                        break;
                    case 'absolonkent.net':
                        $icon = 'fa fa-link';
                        $url_filtered = preg_replace('/(?:www\.)?absolonkent\.net\/(\w*).*/','$1',$url_display);
                        break;
                    case 'design.cricut.com':
                        $icon = 'fa fa-link';
                        $url_filtered = preg_replace('/design.cricut.com\/(\w*).*/','$1',$url_display);
                        break;
                    case 'mastodon.social':
                        $icon = 'fa fa-link';
                        break;
                    case 'leagueofcomicgeeks.com':
                        $icon = 'fa fa-book';
                        break;
                    default:
                        $icon = 'fa fa-link';
                        $url_filtered = $url_display;
                        break;
                }

                $url_display = $url_filtered;

                $scheme = parse_url($url, PHP_URL_SCHEME);
                switch ($scheme) {
                    case 'mailto' :
                        $icon = 'fa-envelope-square'; $url_display = str_replace('mailto:', '', $url_display); $h_card = 'u-email';
                        break;
                    case 'sms' :
                        $icon = 'fa-mobile'; $url_display = str_replace('sms:', '', $url_display); $h_card = 'p-tel';
                        break;
                    case 'sip' :
                    case 'tel' :
                        $icon = 'fa-phone-square'; $url_display = str_replace('tel:', '', $url_display); $h_card = 'p-tel';
                        break;
                    case 'skype' :
                        $icon = 'fa-skype'; $url_display = str_replace('skype:', '', $url_display); $h_card = 'p-skype';
                        break;
                    case 'bitcoin':
                        $icon = 'fa-btc'; $url_display = str_replace('bitcoin:', '', $url_display); $h_card = 'p-bitcoin';
                        break;
                    case 'facetime' :
                        $icon = 'fa-video-camera'; $url_display = str_replace('facetime:', '', $url_display); $h_card = 'p-facetime';
                        break;
                }

?>
        <p class="url-container">
          <i class="fa <?=$icon?> fa-fw" aria-hidden="true"></i>
          <a href="<?=htmlspecialchars($url)?>" rel="me" class="<?=$h_card; ?>"><?=str_replace('http://','',str_replace('https://','', strip_tags($url_display)))?></a>
        </p>
<?php
            }
        }
    }
?>
