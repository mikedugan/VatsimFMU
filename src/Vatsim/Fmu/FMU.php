<?php namespace Vatsim\Fmu;

use Vatsim\Fmu\VatsimFMUException;

class FMU
{

    private $_client = "VFMU Client 1.0";
    private $_config = [];

    public function __construct($cfg)
    {
        $this->_config = $cfg;
    }

    public function request($url_id, $data = [])
    {
        // Determine the method (GET/PATCH/DELETE/POST) etc.
        if (! strpos($url_id, ":")) {
            $method = "GET";
            $url_id = $url_id;
        } else {
            $method = strtoupper(substr($url_id, 0, strpos($url_id, ":")));
            $url_id = substr($url_id, strpos($url_id, ":") + 1);
        }

        // Now find out what the URL *actually* is.
        if (! array_key_exists($url_id, $this->_config['api_urls'][$method])) {
            throw new VatsimFMUException("Invalid URL specified.", 404);
        }

        // Build the URL
        $url = $this->_config['api_url_base'];
        $url .= $this->_config['api_urls'][$method][$url_id];
        $url .= "?api_key=" . urlencode($this->_config['api_key']);

        foreach ($data as $key => $value) {
            if (preg_match("/\{" . $key . "}/i", $url)) {
                $url = str_replace("{" . $key . "}", $value, $url);
                unset($data[$key]);
            }
        }

        // Now run the request!
        return $this->{strtolower($method) . "Request"}($url, $data);
    }

    private function deleteRequest($url, $data)
    {
        return $this->postRequest($url, $data, "DELETE");
    }

    private function postRequest($url, $data = [], $customType = "POST")
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL            => $url,
            CURLOPT_USERAGENT      => $this->_client,
            CURLOPT_TIMEOUT        => 3,
            CURLOPT_CUSTOMREQUEST  => strtoupper($customType),
            CURLOPT_POSTFIELDS     => $data,
        ]);

        return $this->executeCurl($curl);
    }

    private function getRequest($url, $data = [])
    {
        // Add all the data to the end of the URL.
        foreach ($data as $key => $value) {
            $url .= "&" . $key . "=" . urlencode($value);
        }

        try {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL            => $url,
                CURLOPT_USERAGENT      => $this->_client,
                CURLOPT_TIMEOUT        => 3,
                CURLOPT_CUSTOMREQUEST  => "GET",
            ]);
        } catch (\Exception $e) {
            throw new VatsimFMUException("Could not create request.", 400);
        }

        return $this->executeCurl($curl);
    }

    private function executeCurl($curl)
    {
        try {
            $response = json_decode(curl_exec($curl));
            curl_close($curl);
        } catch (\Exception $e) {
            throw new VatsimFMUException("Could not access remote URL", 404);
        }

        return $response;
    }
}
