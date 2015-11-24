<?php
$countryArray = array(   
    'AE' => 'United Arab Emirates', 'AF' => 'Afghanistan', 'AG' => 'Antigua and Barbuda', 
    'AL' => 'Albania', 'AM' => 'Armenia', 'AO' => 'Angola', 'AR' => 'Argentia', 
    'AT' => 'Austria', 'AU' => 'Australia', 'AZ' => 'Azerbaijan', 'BA' => 'Bosnia and Herzegovina', 
    'BB' => 'Barbados', 'BD' => 'Bangladesh', 'BE' => 'Belgium', 'BF' => 'Burkina Faso', 
    'BG' => 'Bulgaria', 'BI' => 'Burundi', 'BJ' => 'Benin', 'BN' => 'Brunei Darussalam', 
    'BO' => 'Bolivia', 'BR' => 'Brazil', 'BS' => 'Bahamas', 'BT' => 'Bhutan', 
    'BW' => 'Botswana', 'BY' => 'Belarus', 'BZ' => 'Belize', 'CA' => 'Canada', 
    'CD' => 'Congo', 'CF' => 'Central African Republic', 'CG' => 'Congo', 'CH' => 'Switzerland', 
    'CI' => "Cote d'Ivoire", 'CL' => 'Chile', 'CM' => 'Cameroon', 'CN' => 'China', 'CO' => 'Colombia', 
    'CR' => 'Costa Rica', 'CU' => 'Cuba', 'CV' => 'Cape Verde', 'CY' => 'Cyprus', 
    'CZ' => 'Czech Republic', 'DE' => 'Germany', 'DJ' => 'Djibouti', 'DK' => 'Denmark', 
    'DM' => 'Dominica', 'DO' => 'Dominican Republic', 'DZ' => 'Algeria', 'EC' => 'Ecuador', 
    'EE' => 'Estonia', 'EG' => 'Egypt', 'ER' => 'Eritrea', 'ES' => 'Spain', 'ET' => 'Ethiopia', 
    'FI' => 'Finland', 'FJ' => 'Fiji', 'FK' => 'Falkland Islands', 'FR' => 'France', 'GA' => 'Gabon', 
    'GB' => 'United Kingdom', 'GD' => 'Grenada', 'GE' => 'Georgia', 'GF' => 'French Guiana', 
    'GH' => 'Ghana', 'GL' => 'Greenland', 'GM' => 'Gambia', 'GN' => 'Guinea', 'GQ' => 'Equatorial Guinea', 
    'GR' => 'Greece', 'GT' => 'Guatemala', 'GW' => 'Guinea-Bissau', 'GY' => 'Guyana', 'HN' => 'Honduras', 
    'HR' => 'Croatia', 'HT' => 'Haiti', 'HU' => 'Hungary', 'ID' => 'Indonesia', 'IE' => 'Ireland', 
    'IL' => 'Israel', 'IN' => 'India', 'IQ' => 'Iraq', 'IR' => 'Iran', 'IS' => 'Iceland', 
    'IT' => 'Italy', 'JM' => 'Jamaica', 'JO' => 'Jordan', 'JP' => 'Japan', 'KE' => 'Kenya', 
    'KG' => 'Kyrgyz Republic', 'KH' => 'Cambodia', 'KM' => 'Comoros', 'KN' => 'Saint Kitts and Nevis', 
    'KP' => 'North Korea', 'KR' => 'South Korea', 'KW' => 'Kuwait', 'KZ' => 'Kazakhstan', 
    'LA' => "Lao People's Democratic Republic", 'LB' => 'Lebanon', 'LC' => 'Saint Lucia', 
    'LK' => 'Sri Lanka', 'LR' => 'Liberia', 'LS' => 'Lesotho', 'LT' => 'Lithuania', 'LV' => 'Latvia', 
    'LY' => 'Libya', 'MA' => 'Morocco', 'MD' => 'Moldova', 'MG' => 'Madagascar', 'MK' => 'Macedonia', 
    'ML' => 'Mali', 'MM' => 'Myanmar', 'MN' => 'Mongolia', 'MR' => 'Mauritania', 'MT' => 'Malta', 
    'MU' => 'Mauritius', 'MV' => 'Maldives', 'MW' => 'Malawi', 'MX' => 'Mexico', 'MY' => 'Malaysia', 
    'MZ' => 'Mozambique', 'NA' => 'Namibia', 'NC' => 'New Caledonia', 'NE' => 'Niger', 
    'NG' => 'Nigeria', 'NI' => 'Nicaragua', 'NL' => 'Netherlands', 'NO' => 'Norway', 'NP' => 'Nepal', 
    'NZ' => 'New Zealand', 'OM' => 'Oman', 'PA' => 'Panama', 'PE' => 'Peru', 'PF' => 'French Polynesia', 
    'PG' => 'Papua New Guinea', 'PH' => 'Philippines', 'PK' => 'Pakistan', 'PL' => 'Poland', 
    'PT' => 'Portugal', 'PY' => 'Paraguay', 'QA' => 'Qatar', 'RE' => 'Reunion', 'RO' => 'Romania', 
    'RS' => 'Serbia', 'RU' => 'Russian FederationÃŸ', 'RW' => 'Rwanda', 'SA' => 'Saudi Arabia', 
    'SB' => 'Solomon Islands', 'SC' => 'Seychelles', 'SD' => 'Sudan', 'SE' => 'Sweden', 
    'SI' => 'Slovenia', 'SK' => 'Slovakia', 'SL' => 'Sierra Leone', 'SN' => 'Senegal', 
    'SO' => 'Somalia', 'SR' => 'Suriname', 'ST' => 'Sao Tome and Principe', 'SV' => 'El Salvador', 
    'SY' => 'Syrian Arab Republic', 'SZ' => 'Swaziland', 'TD' => 'Chad', 'TG' => 'Togo', 
    'TH' => 'Thailand', 'TJ' => 'Tajikistan', 'TL' => 'Timor-Leste', 'TM' => 'Turkmenistan', 
    'TN' => 'Tunisia', 'TR' => 'Turkey', 'TT' => 'Trinidad and Tobago', 'TW' => 'Taiwan', 
    'TZ' => 'Tanzania', 'UA' => 'Ukraine', 'UG' => 'Uganda', 'US' => 'United States of America', 
    'UY' => 'Uruguay', 'UZ' => 'Uzbekistan', 'VE' => 'Venezuela', 'VN' => 'Vietnam', 'VU' => 'Vanuatu', 
    'YE' => 'Yemen', 'ZA' => 'South Africa', 'ZM' => 'Zambia','ZW' => 'Zimbabwe' 
);

function secure( $data, $isPass = false )
{
    $data = htmlspecialchars(trim(  $data ));
    $data = $isPass ? hash( 'sha512', $data . 'REETEKCOR' ) : $data;
    return $data;
}

function get_extension($file_name)
{
    $ext = explode('.', $file_name);
    $ext = array_pop($ext);
    return strtolower($ext);
}

function isReady( $dataArray, $checkArray )
{
    foreach( $checkArray as $key )
    {
        if(isset($dataArray[$key]) && !empty($dataArray[$key]))
        {
            continue;
        }
        else
        {
            return false;
        }
    }
    return true;
}

function get_random_string( $length,  $onlyLetters    =    false )
{
    if( $onlyLetters ){
        $valid_chars   =   "abcdefghijklmnopqrstuvwxyz";
    }else{
        $valid_chars   =   "ABCDEFGHIJLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789";
    }

    // start with an empty random string
    $random_string = "";

    // count the number of chars in the valid chars string so we know how many choices we have
    $num_valid_chars = strlen($valid_chars);

    // repeat the steps until we've created a string of the right length
    for ($i = 0; $i < $length; $i++)
    {
        // pick a random number from 1 up to the number of valid chars
        $random_pick = mt_rand(1, $num_valid_chars);

        // take the random character out of the string of valid chars
        // subtract 1 from $random_pick because strings are indexed starting at 0, and we started picking at 1
        $random_char = $valid_chars[$random_pick-1];

        // add the randomly-chosen char onto the end of our string so far
        $random_string .= $random_char;
    }

    // return our finished random string
    return $random_string;
}

function httpGet($url)
{
    $ch = curl_init();  

    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_TIMEOUT, '3');
    curl_setopt($ch,CURLOPT_HEADER, false); 

    $output=curl_exec($ch);

    curl_close($ch);
    return $output;
}

/** 
* Converts bytes into human readable file size. 
* 
* @param string $bytes 
* @return string human readable file size (2,87 Мб)
* @author Mogilev Arseny 
*/ 
function FileSizeConvert($bytes)
{
    $bytes = floatval($bytes);
    $arBytes = array(
        0 => array(
            "UNIT" => "TB",
            "VALUE" => pow(1024, 4)
        ),
        1 => array(
            "UNIT" => "GB",
            "VALUE" => pow(1024, 3)
        ),
        2 => array(
            "UNIT" => "MB",
            "VALUE" => pow(1024, 2)
        ),
        3 => array(
            "UNIT" => "KB",
            "VALUE" => 1024
        ),
        4 => array(
            "UNIT" => "B",
            "VALUE" => 1
        ),
    );

    foreach($arBytes as $arItem)
    {
        if($bytes >= $arItem["VALUE"])
        {
            $result = $bytes / $arItem["VALUE"];
            $result = strval(round($result, 2))." ".$arItem["UNIT"];
            break;
        }
    }
    return $result;
}

function jkof_get_ip() {
    //Just get the headers if we can or else use the SERVER global
    if ( function_exists( 'apache_request_headers' ) ) {
        $headers = apache_request_headers();
    }else{
        $headers = $_SERVER;
    }

    //Get the forwarded IP if it exists
    if ( array_key_exists( 'X-Forwarded-For', $headers ) && filter_var( $headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {
        $the_ip = $headers['X-Forwarded-For'];
    }else if( array_key_exists( 'HTTP_X_FORWARDED_FOR', $headers ) && filter_var( $headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 )
            ) {
        $the_ip = $headers['HTTP_X_FORWARDED_FOR'];
    }else{
        $the_ip = filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 );
    }
    return $the_ip;
}

/* creates a compressed zip file */
function create_zip($files = array(),$destination = '', $upl_dir = 'guests', $overwrite = false) {
    //if the zip file already exists and overwrite is false, return false
    if(file_exists($destination) && !$overwrite) { return false; }
    //vars
    $valid_files = array();
    //if files were passed in...
    if(is_array($files)) {
        //cycle through each file
        foreach($files as $file) {
            //make sure the file exists
            if(file_exists(OF_DIR . "/" . $upl_dir . '/' . $file)) {
                $valid_files[] = $file;
            }
        }
    }

    //if we have good files...
    if(count($valid_files)) {
        //create the archive
        $zip = new ZipArchive();
        if($zip->open($destination, $overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
            return false;
        }
        //add the files
        foreach($valid_files as $file) {
            $zip->addFile(OF_DIR . "/" . $upl_dir . '/' . $file,$file);
        }
        //debug
        //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
        //close the zip -- done!
        $zip->close();

        //check to make sure the file exists
        return file_exists($destination);
    }
    else
    {
        return false;
    }
}

function ZipStatusString( $status )
{
    switch( (int) $status )
    {
        case ZipArchive::ER_OK           : return 'N No error';
        case ZipArchive::ER_MULTIDISK    : return 'N Multi-disk zip archives not supported';
        case ZipArchive::ER_RENAME       : return 'S Renaming temporary file failed';
        case ZipArchive::ER_CLOSE        : return 'S Closing zip archive failed';
        case ZipArchive::ER_SEEK         : return 'S Seek error';
        case ZipArchive::ER_READ         : return 'S Read error';
        case ZipArchive::ER_WRITE        : return 'S Write error';
        case ZipArchive::ER_CRC          : return 'N CRC error';
        case ZipArchive::ER_ZIPCLOSED    : return 'N Containing zip archive was closed';
        case ZipArchive::ER_NOENT        : return 'N No such file';
        case ZipArchive::ER_EXISTS       : return 'N File already exists';
        case ZipArchive::ER_OPEN         : return 'S Can\'t open file';
        case ZipArchive::ER_TMPOPEN      : return 'S Failure to create temporary file';
        case ZipArchive::ER_ZLIB         : return 'Z Zlib error';
        case ZipArchive::ER_MEMORY       : return 'N Malloc failure';
        case ZipArchive::ER_CHANGED      : return 'N Entry has been changed';
        case ZipArchive::ER_COMPNOTSUPP  : return 'N Compression method not supported';
        case ZipArchive::ER_EOF          : return 'N Premature EOF';
        case ZipArchive::ER_INVAL        : return 'N Invalid argument';
        case ZipArchive::ER_NOZIP        : return 'N Not a zip archive';
        case ZipArchive::ER_INTERNAL     : return 'N Internal error';
        case ZipArchive::ER_INCONS       : return 'N Zip archive inconsistent';
        case ZipArchive::ER_REMOVE       : return 'S Can\'t remove file';
        case ZipArchive::ER_DELETED      : return 'N Entry has been deleted';

        default: return sprintf('Unknown status %s', $status );
    }
}

function jkof_dj($arr){
    die(json_encode($arr));
}

function jkof_get_dl_defaults(){
    $jkof_settings              =   get_option( 'jkof_settings' );

    return array(
        'label'                 =>  'Download File',
        'dl_limit'              =>  0,
        'dl_user_limit'         =>  0,
        'dl_daily_limit'        =>  0,
        'view_count'            =>  0,
        'dl_count'              =>  0,
        'indiv_dls'             =>  1,
        'audio_player'          =>  1,
        'available'             =>  '',
        'expires'               =>  '',
        'access_level'          =>  array("Guests","Subscriber","Contributor","Author","Editor","Administrator"),
        'users_allowed'         =>  '',
        'users_disallowed'      =>  '',
        'lock_opts'             =>  array(),
        'lock_password'         =>  null,
        'lock_li_m'             =>  null,
        'lock_li_url'           =>  null,
        'lock_fb_like_url'      =>  null,
        'lock_twitter_u'        =>  @$jkof_settings['twitter_username'],
        'lock_tweet_m'          =>  null,
        'lock_gplus_url'        =>  null,
        'lock_email_type'       =>  null,
        'lock_pp_amount'        =>  '0.00',
        'color'                 =>  'rcw-green',
        'size'                  =>  'rcw-large',
        'effect'                =>  null,
        'enhancement'           =>  null,
        'shape'                 =>  null,
        'style'                 =>  'rcw-button-0'
    );
}