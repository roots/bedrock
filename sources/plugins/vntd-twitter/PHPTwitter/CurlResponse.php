<?php


/**
 * A wrapper to handle a curl response.
 *
 * @package PHPTwitter
**/
class CurlResponse {

    /**
     * Store the http status code.
     * @var int
    **/
    protected $statusCode = 0;
    
    /**
     * Stores the headers of a curl response
     * @var array
    **/
    protected $headers = array();
    
    /**
     * Stores the unparsed body of a curl response
     * @var string
    **/
    protected $body = "";
    
    
    
    /**
     * Executes the curl request and deals with the response.
     * @param $ch - valid curl handle.
     * @param $close boolean - whether to close the curl handle after setup. default: true
    **/
    public function __construct(&$ch, $close = true) {
        $this->body = (string) curl_exec($ch);
        $this->statusCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $this->headers = (array) curl_getinfo($ch);
        
        if($close == true)
            curl_close($ch);
    }
    
    
    /**
     * Returns the status code of the response
     * @return int
    **/
    public function statusCode() {
        return (int) $this->statusCode;
    }
    
    
    /**
     * Returns the headers from the curl response
     * @return array
    **/
    public function headers() {
        return (array) $this->headers;
    }
    
    /**
     * Returns the unparsed body of the response
     * @return (string)
    **/
    public function body() {
        return (string) $this->body;
    }
}
?>
