<?php
/**
 * @brief Date and Time Class
 * This class will use nesbot/carbon package for date and time functions
 *
 * Examples:
 * echo Carbon::now($timezone=null); //current date and time using timezone
 * echo Carbon::now()->tzName; //Australia/Brisbane
 * echo Carbon::now()->format('Y-m-d'); //2017-03-29
 *
 */

// import the namespace to use Carbon
use Carbon\Carbon;

class carbonDateTime{

    //Default timezone
    private $dtz;

    //New instance of Carbon
    private $c;

    //Standard datetime format
    private $std_format = 'Y-m-d H:i:s';


    /**
     * @brief Create a new carbonDateTime instance
     *
     * @param array
     */
    public function __construct($config){
        $this->dtz = $config["DEFINE"]['TIMEZONE'];

        //Create date with default timezone
        $this->c = Carbon::now($this->dtz);
    }


    /*
     * @brief Get date and time using timezone
     *
     * @return string
     */
    public function getCurrentDateTime($tz=null){
        if($tz == null){
            return $this->c->toDateTimeString();

        }else{
            return Carbon::now($tz)->toDateTimeString();
        }
    }


    /*
     * @brief Get date using timezone
     *
     * @return string
     */
    public function getCurrentDate($tz=null){
        if($tz == null){
            return $this->c->toDateString();
        }else{
            return Carbon::now($tz)->toDateString();
        }
    }


    /*
     * @brief Convert user date and time to server date and time
     * Example: convertToLocalTz('2017-04-04 06:45', 'Asia/Kathmandu'); //Return 11:00 (Brisbane)
     *
     * @param string $user_date -User date and time
     * @param string $user_tz -User timezone
     * @return string -Server date and time
     */
    public function convertToServerTz($user_date, $user_tz){
        //Standard datetime format
        $timestamp = $this->formatDate($user_date, $this->std_format);

        //Convert to UTC timezone
        $dt_utc = $this->convertToUTC($timestamp, $user_tz);
        $dt_utc->timezone($this->dtz);

        return $dt_utc;
    }


    /*
     * @brief Convert server date and time to given user's timezone
     * Example: convertToServerTz('2017-04-04 11:00', 'Asia/Kathmandu'); //Return 06:45 (Kathmandu)
     *
     * @param string $inpt_date -Server date and time
     * @param string $tz -User timezone
     * @return string -Local date and time
     */
    public function convertToUserTz($server_date, $user_tz){
        //Standard datetime format
        $timestamp = $this->formatDate($server_date, $this->std_format);

        //Convert to UTC timezone
        $dt_utc = $this->convertToUTC($timestamp, $this->dtz);
        $dt_utc->timezone($user_tz);

        return $dt_utc;
    }


    /*
     * @brief Format date
     *
     * @return string
     */
    public function formatDate($date, $format='Y-d-m'){
        return date($format, strtotime($date));
    }


    /**
     * @brief Convert date and time to UTC (Using default timezone)
     *
     * @return string UTC timezone
     */
    public function convertToUTC($inpt_date, $tz){
        //Parse timestamp using default timezone (server timezone)
        $date = Carbon::createFromFormat($this->std_format, $inpt_date, $tz);

        //Convert to UTC
        return $date->setTimezone('UTC');
    }


    /*
     * @brief Get timezone name
     *
     * @return string
     */
    public function getTimezone(){
        return $this->c->tzName;
    }


    /**
     * @brief Get diffences between two dates in given unit
     *
     * Eg: getDateDiff('2017-03-31 17:10:02','2017-03-31 21:25:02')  // 4
     * Eg: getDateDiff('2017-03-31 21:25:02','2017-03-31 17:10:02')  // -4
     *
     * @return int
     */
    public function getDateDiff($inpt_date1, $inpt_date2, $diff_in="hours"){
        $date1 = Carbon::createFromFormat($this->std_format, $inpt_date1, $this->dtz);
        $date2 = Carbon::createFromFormat($this->std_format, $inpt_date2, $this->dtz);
        switch ($diff_in){
            case "hours":
                return $date1->diffInHours($date2, FALSE);
            case "minutes":
                return $date1->diffInMinutes($date2, FALSE);
            default :
                return $date1->diffInSeconds($date2, FALSE);
        }
    }


    /**
    * @brief Get an array of timezones
    *
    * @return array
    */
    public function getTimezonesList()
    {
        $timezoneIdentifiers = DateTimeZone::listIdentifiers();
        $utcTime = new DateTime('now', new DateTimeZone('UTC'));


        $tempTimezones = array();
        foreach ($timezoneIdentifiers as $timezoneIdentifier) {
           $currentTimezone = new DateTimeZone($timezoneIdentifier);
           $tempTimezones[] = array(
                'offset' => (int)$currentTimezone->getOffset($utcTime),
                'identifier' => $timezoneIdentifier
           );
        }

        // Sort the array by offset,identifier ascending
        usort($tempTimezones, function($a, $b) {
            return ($a['offset'] == $b['offset'])? strcmp($a['identifier'], $b['identifier']):$a['offset'] - $b['offset'];
        });

        $timezoneList = array();
        foreach ($tempTimezones as $tz) {
            $sign = ($tz['offset'] > 0) ? '+' : '-';
            $offset = gmdate('H:i', abs($tz['offset']));
            $timezoneList[$tz['identifier']] = '(UTC ' . $sign . $offset . ') ' . $tz['identifier'];
        }

        return $timezoneList;
    }


    /**
     * @brief Get timezone offset for given timezone name
     * @param string $tzName Timezone name
     * @return string UTC offset
     */
    public function getTimezoneOffset($tzName){
        //Get Offset
        $dtz = new DateTimeZone($tzName);
        $utcTime = new DateTime('now', $dtz);
        $offset_raw = $dtz->getOffset( $utcTime );

        //Format UTC offset Eg. UTC +05:45
        $sign = ($offset_raw > 0) ? '+' : '-';
        $offset = gmdate('H:i', abs($offset_raw));
        return "UTC ". $sign . $offset;
    }


    /**
     * @brief Check valid time zone
     *
     * return boolean
     */
    public function checkValidTz($inpt_tzName){
        return in_array($inpt_tzName, DateTimeZone::listIdentifiers())? true: false;
    }
    

    /**
     * Added for test purpose
     */
    public function seconds2human($seconds) {
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$seconds");
        return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
    }
}
