<?php
    if (!empty($vars['user']->profile['url']) && is_array($vars['user']->profile['url'])) {

        // Centralized ID-to-handle mapping for platforms that use numeric/opaque IDs
        $id_to_handle = [
            '1111111111111111111111111' => '@username', // Gram.social
            '1111111111111111111111111' => '@username', // Cricut
            '11111111111'               => '@username', // Spotify
        ];

        foreach($vars['user']->profile['url'] as $url) {
            if (!empty($url)) {

                // Defaults
                $h_card = 'u-url';
                $icon   = 'fa-link';

                // Quick shim for handle-style URLs
                if ($url[0] == '@') {
                    if (preg_match('/^\@[a-z0-9_]+$/i', $url)) {
                        $url = 'https://x.com/' . ltrim($url, '@');
                    }
                }

                $url         = $this->fixURL($url);
                $url_display = rtrim($url, '/');

                // Extract the last segment of the URL as the default handle
                $url_parts    = explode('/', $url_display);
                $url_filtered = end($url_parts);

                $host = parse_url($url, PHP_URL_HOST);
                $host = str_replace('www.', '', $host);

                // Determine icon and display handle based on host
                if ($host === 'twitter.com') {
                    $icon = 'fa-twitter-square';

                } elseif ($host === 'x.com') {
                    $icon = 'fa-twitter-square';

                } elseif ($host === 'github.com') {
                    $icon = 'fa-github-square';

                } elseif ($host === 'facebook.com') {
                    $icon = 'fa-facebook-square';

                } elseif ($host === 'linkedin.com') {
                    $icon = 'fa-linkedin-square';

                } elseif ($host === 'instagram.com') {
                    $icon = 'fa-instagram';

                } elseif ($host === 'threads.net') {
                    $icon = 'fa-at'; 

                } elseif ($host === 'medium.com') {
                    $icon = 'fa-medium';

                } elseif ($host === 'pinterest.com') {
                    $icon = 'fa-pinterest-square';

                } elseif ($host === 'untappd.com') {
                    $icon = 'fa-untappd'; 

                } elseif ($host === 'reddit.com') {
                    $icon = 'fa-reddit-square';

                } elseif ($host === 'youtube.com') {
                    $icon = 'fa-youtube-square';

                } elseif ($host === 'tiktok.com') {
                    $icon = 'fa-music';

                } elseif ($host === 'mastodon.social') {
                    $icon = 'fa-mastodon-square';

                } elseif ($host === 'twitch.tv') {
                    $icon = 'fa-twitch';

                } elseif ($host === 'flickr.com') {
                    $icon = 'fa-flickr';

                } elseif ($host === 'ko-fi.com') {
                    $icon = 'fa-coffee';

                } elseif ($host === 'paypal.me' || $host === 'paypal.com') {
                    $icon = 'fa-paypal';

                } elseif ($host === 'libib.com' || $host === 'leagueofcomicgeeks.com') {
                    $icon = 'fa-book';

                } elseif ($host === 'gram.social') {
                    $icon = 'fa-camera-retro';
                    $path     = trim(parse_url($url, PHP_URL_PATH), '/');
                    $id_check = str_replace('i/web/profile/', '', $path);
                    $url_filtered = $id_to_handle[$id_check] ?? '@' . $id_check;

                } elseif ($host === 'design.cricut.com') {
                    $icon = 'fa-scissors';
                    $url_filtered = $id_to_handle[$url_filtered] ?? '@' . $url_filtered;

                } elseif (preg_match('/.*spotify\.com/', $host)) {
                    $icon = 'fa-spotify';
                    $url_filtered = $id_to_handle[$url_filtered] ?? '@' . $url_filtered;

                } elseif ($host === 'bsky.app' || preg_match('/.*bsky\.social/', $host)) {
                    $icon = 'fa-cloud'; 
                    $url_filtered = '@' . str_replace('.bsky.social', '', $url_filtered);

                } elseif (preg_match('/.*wordpress\.com/', $host)) {
                    $icon = 'fa-wordpress';
                    $url_filtered = '@' . str_replace('.wordpress.com', '', $host);
                }

                $url_display = $url_filtered;

                // Handle protocol schemes (mailto, tel, sms)
                $scheme = parse_url($url, PHP_URL_SCHEME);
                switch ($scheme) {
                    case 'mailto':
                        $icon        = 'fa-envelope';
                        $url_display = str_replace('mailto:', '', $url_display);
                        $h_card      = 'u-email';
                        break;
                    case 'tel':
                        $icon        = 'fa-phone-square';
                        $url_display = str_replace('tel:', '', $url_display);
                        $h_card      = 'p-tel';
                        break;
                    case 'sms':
                        $icon        = 'fa-mobile';
                        $url_display = str_replace('sms:', '', $url_display);
                        $h_card      = 'p-tel';
                        break;
                }
?>
        <p class="url-container" style="margin-bottom: 8px;">
          <i class="fa <?=$icon?> fa-fw" aria-hidden="true"></i>
          <a href="<?=htmlspecialchars($url)?>" rel="me" class="<?=$h_card?>" style="text-decoration: none;">
            <?=strip_tags($url_display)?>
          </a>
        </p>
<?php
            }
        }
    }
?>
