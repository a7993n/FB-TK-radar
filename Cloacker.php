<!-- Class cloacker to detect tiktok/facebook crawler -->
<?php

class Cloacker
{


    public function __construct()
    {
        $this->user_agent = $_SERVER['HTTP_USER_AGENT'];
        $this->is_crawler = $this->is_crawler();
        //execute save headers
        $this->save_headers();
        //execute save users ip
        $this->save_users_ip();

    }

    //ip detection and localisation free api
    public function get_ip()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
        return $details;
    }



    //check if is browser header is preview fb/tiktok
    public function is_preview()
    {
        if (isset($_SERVER['HTTP_X_FB_IS_INSTANT_ARTICLE']) || isset($_SERVER['HTTP_X_FB_IS_INSTANT_ARTICLE'])) {
            return "FB preview detected";
        } elseif (isset($_SERVER['HTTP_X_TIKTOK_USER_AGENT'])) {
            return "TK preview detected";
        } else {
            return "No preview detected";
        }

    }

    //this function check if is crawler
    public function is_crawler()
    {
        $crawlers_agents = array(
            'facebookexternalhit',
            'Facebot',
            'tiktok-crawler',
            'TikTokBot',
        );

        foreach ($crawlers_agents as $crawler) {
            if (stripos($this->user_agent, $crawler) !== false) {
                return "Crawler detected";
            } else {
                return "No FB/TK Crawler detected";
            }
        }
    }

    //test if its facbook ip servers
    public function is_ip()
    {

        $facebook_ips = array(
            /* facebook ips */
            '129.134.0.0',
            '129.134.25.0',
            '129.134.26.0'

        );

        $ip = $this->get_ip();


        /* check if is tiktok ips */
        $tiktok_ips = array(
            '64.233.164.126'
        );

        if (in_array($ip->ip, $facebook_ips)) {
            return "Facebook ip detected";
        } elseif (in_array($ip->ip, $tiktok_ips)) {
            return "Tiktok ip detected";
        } else {
            return "No TIK/FB ip detected";
        }


    }

    //detect if is mobile   
    public function is_mobile()
    {
        if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/Mobile|Android|BlackBerry|Opera Mini|IEMobile/i', $_SERVER['HTTP_USER_AGENT'])) {
            return "Mobile detected";
        } else {
            return "No mobile detected";
        }
    }

    //if its a proxy cdn cloudflare
    public function is_proxy()
    {
        if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            return "Proxy detected";
        } else {
            return "No proxy detected";
        }
    }

    //get all browser headers and details
    public function show_headers()
    {
        $headers = apache_request_headers();
        $headers = json_encode($headers);
        return $headers;
    }

    //save all headers in a file for debug headers.log
    public function save_headers()
    {
        $headers = apache_request_headers();
        $headers = json_encode($headers);
        $myfile = fopen("./headers.log", "w") or die("Unable to open file!");
        fwrite($myfile, $headers);
        fclose($myfile);
    }

    //save new crawler ip in a file
    public function save_crawler_ip()
    {
        $ip = $this->get_ip();
        $myfile = fopen("./crawler_ip.log", "w") or die("Unable to open file!");
        fwrite($myfile, $ip->ip);
        fclose($myfile);
    }


    //save users ip in a file
    public function save_users_ip()
    {
        $ip = $this->get_ip();
        $myfile = fopen("./users_ip.log", "w") or die("Unable to open file!");
        fwrite($myfile, $ip->ip);
        fclose($myfile);
    }

}