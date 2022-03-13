<?php

namespace NewsAggregator\helpers;

include_once __DIR__ . '/formatURL.php';

use function NewsAggregator\helpers\formatURL;


use DateTime;
use Exception;
//set timezone
date_default_timezone_set('America/Los_Angeles');
class RSSCacheModel
{
    public $cacheTime;
    public $xmlStr;
    public $inSesstion = false;
    public function __construct($xmlStr)
    {
        $this->xmlStr = $xmlStr;
        $this->cacheTime = new DateTime();
        //add 15 minutes to current time for expiration time
        $this->expiration = date_add(new DateTime(), date_interval_create_from_date_string('15 minutes'));
    }

    public function __get($name)
    {
        if ($name == "xml") {
            //conver xml string to simplexml object 
            return simplexml_load_string($this->xmlStr);
        }
        throw new Exception("Undefined property: Category::$name");
    }


    /**
     * fetchRSSData
     *
     * @param  string $feedName
     * @param  string $categoryName
     * @return RSSCacheModel
     */
    public static function fetchRSSData($feedName, $categoryName)
    {
        //the name in session
        $nameInSession = $categoryName . '_' . $feedName;
        $RSSObj = null;
        //return the 
        if (isset($_SESSION[$nameInSession]) && new DateTime() <  $_SESSION[$nameInSession]->expiration && strtoupper($_SERVER["REQUEST_METHOD"]) !== "POST") {
            $RSSObj = $_SESSION[$nameInSession];
            $RSSObj->inSesstion = true;
        } else {
            // parse names, replacing spaces with +
            $url = formatURL($feedName);
            // fetch xml data
            $response = file_get_contents($url);
            //$xml = simplexml_load_string($response); //create readable xml
            //store stirng of xml in rss obj, if store simplexml object in session, error will happen . 
            $RSSObj = new RSSCacheModel($response); //create rss object
            //store rss object in session
            $_SESSION[$nameInSession] = $RSSObj;
        }
        return  $RSSObj;
    }
}
