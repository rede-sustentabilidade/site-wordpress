<?php

class ApiRede
{
    protected static $instances;

    protected $apiPath;

    protected function __construct()
    {
        $this->apiPath = WP_API_PATH;
	}

    final private function __clone()
    {

    }

    public static function getInstance()
    {
        $class = get_called_class();

        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new $class;
        }
        return self::$instances[$class];
    }

    public function UpdateFullName($user_id, $fullname)
    {
        $service_url = $this->apiPath . '/usuario/updatefullname/'.$user_id.'/name/'.urlencode($fullname);
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
              CURLOPT_URL            => $service_url,
            CURLOPT_RETURNTRANSFER => true,
            //CURLOPT_HEADER         => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_AUTOREFERER    => true,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_TIMEOUT        => 120,
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => FALSE
        ));

        // Send the request & save response to $resp
        $curl_response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        // Close request to clear up some resources
        curl_close($curl);
        if ($httpCode !== 200) {
            return array();
        } else {
            return json_decode($curl_response);
        }
    }

    public function getProfile($id)
    {
        return $this->call('/profile/'.$id);
    }

    public function updateProfile(array $profile)
	{
        return $this->call('/profile/'.$profile['user_id'], 'POST', $profile);
    }

    public function getPayments()
    {
        $return = $this->call('/payment');
        return !empty($return->data) ? $return->data : null;
    }

    public function getPayment($id)
    {
        $return = $this->call('/payment/retrieve/'.$id);
        return !empty($return->data) ? $return->data : null;
    }

    public function updatePaymentCall($id, $status = 0)
    {
        return $this->call('/payment/call/'.$id, 'POST', array('status' => $status));
    }

    public function getPaymentProfiles()
    {
        $return = $this->call('/payment/profiles');
        return !empty($return->data) ? $return->data : null;
    }

    private function call($route, $method = 'GET', array $data = null)
    {
        $url = $this->apiPath.$route;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_AUTOREFERER    => true,
            CURLOPT_FORBID_REUSE   => true,
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_TIMEOUT        => 120,
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => FALSE
        ));
        switch ($method) {
            case 'GET':
                if (!empty($data)) {
                    $url .= '?'.http_build_query($data);
                }
                curl_setopt($curl, CURLOPT_URL, $url);
                break;
            case 'POST':
                $json = json_encode($data);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json; charset=utf-8',
                        'Content-Length: ' . strlen($json),
                    ));
                break;
        }
        $response = curl_exec($curl);
        error_log(print_r($response, true));
        error_log(print_r(curl_getinfo($curl), true));
        $httpCode = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if ($httpCode !== 200) {
            if (($json = @json_decode($response)) && !empty($json->errors)) {
                return $json;
            }
            return array('httpCode' => $httpCode);
        }
        return json_decode($response);
    }
}
