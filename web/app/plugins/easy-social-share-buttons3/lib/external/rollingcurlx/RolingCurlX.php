<?php
/*
 * Based on RollingCurlX https://github.com/marcushat/rollingcurlx
 * 
 * @since 4.2
*/
Class RollingCurlX {
    private $_maxConcurrent = 0; //max. number of simultaneous connections allowed
    private $_options = array(); //shared cURL options
    private $_headers = array(); //shared cURL request headers
    private $_callback = NULL; //default callback
    private $_timeout = 1; //timeout used for curl_multi_select() function in seconds. Lower this to zero increases total performance. 
    private $requests = array(); //request_queue  

    function __construct($max_concurrent = 10) {
        $this->setMaxConcurrent($max_concurrent);
    }

    public function setMaxConcurrent($max_requests) {
        if($max_requests > 0) {
            $this->_maxConcurrent = $max_requests;
        }
    }

    public function setOptions(array $options) {
        $this->_options = $options;
    }

    public function setHeaders(array $headers) {
        if(is_array($headers) && count($headers)) {
            $this->_headers = $headers;
        }
    }
	

    //public function setCallback(callable $callback) {
    public function setCallback($callback) {
        $this->_callback = $callback;
    }
    
	/* Bug on php 5.3 Do not use this
	
	*/
    /*public function setTimeout($timeout) { //in milliseconds
        if($timeout > 0) {
            $this->_timeout = $timeout/1000; //to seconds
        }
    }*/

    //Add a request to the request queue
    public function addRequest(
                        $url,
                        array $post_data = NULL,
                        //callable $callback = NULL, //individual callback rhe
                        //$callback = NULL, //individual callback
			array $callback = NULL,
                        $user_data = NULL,
                        array $options = NULL, //individual cURL options
                        array $headers = NULL //individual cURL request headers
    ) { //Add to request queue
        $this->requests[] = array(
            'url' => $url,
            'post_data' => ($post_data) ? $post_data : NULL,
            'callback' => ($callback) ? $callback : $this->_callback,
            'user_data' => ($user_data) ? $user_data : NULL,
            'options' => ($options) ? $options : NULL,
            'headers' => ($headers) ? $headers : NULL
        );
        return count($this->requests) - 1; //return request number/index
    }

    //Reset request queue
    public function reset() {
        $this->requests = array();
    }

    //Execute the request queue
    public function execute() {
        if(count($this->requests) < $this->_maxConcurrent) {
            $this->_maxConcurrent = count($this->requests);
        }
        //the request map that maps the request queue to request curl handles
        $requests_map = array();
        $multi_handle = curl_multi_init();
        //start processing the initial request queue
        for($i = 0; $i < $this->_maxConcurrent; $i++) {
            $ch = curl_init();

            $request =& $this->requests[$i];
            $this->addTimer($request);

            curl_setopt_array($ch, $this->buildOptions($request));
            curl_multi_add_handle($multi_handle, $ch);


            //add curl handle of a request to the request map
            $key = (string) $ch;
            $requests_map[$key] = $i;
        }
        do{
            while(($mh_status = curl_multi_exec($multi_handle, $active)) == CURLM_CALL_MULTI_PERFORM);
            if($mh_status != CURLM_OK) {
                break;
            }

            //a request is just completed, find out which one
            while($completed = curl_multi_info_read($multi_handle)) {
                $ch = $completed['handle'];
                $request_info = curl_getinfo($ch);
                if(curl_errno($ch) !== 0 || intval($request_info['http_code']) !== 200) { //if server responded with http error
                    $response = json_encode(array('error'=>curl_multi_getcontent($ch)));
                } else { //sucessful response
                    $response = curl_multi_getcontent($ch);
                }

                //get request info
                $key = (string) $ch;
                $request =& $this->requests[$requests_map[$key]]; //map handler to request index to get request info
                $url = $request['url'];
                $callback = $request['callback'];
                $user_data = $request['user_data'];
                $options = $request['options'];
                $this->stopTimer($request); //record request time
                $time = $request['time'];

                if($response && (isset($this->_options[CURLOPT_HEADER]) || isset($options[CURLOPT_HEADER]))) {
                    $k = intval($request_info['header_size']);
                    $request_info['response_header'] = substr($response, 0, $k);
                    $response = substr($response, $k);
                }

                //remove completed request and its curl handle
                unset($requests_map[$key]);
                curl_multi_remove_handle($multi_handle, $ch);

                //call the callback function and pass request info and user data to it
                if($callback) {
                    call_user_func($callback, $response, $url, $request_info, $user_data, $time);
                }
                $request = NULL; //free up memory now just incase response was large

                //add/start a new request to the request queue
                if($i < count($this->requests) && isset($this->requests[$i])) { //if requests left
                    $ch = curl_init();

                    $request =& $this->requests[$i];
                    $this->addTimer($request);

                    curl_setopt_array($ch, $this->buildOptions($request));
                    curl_multi_add_handle($multi_handle, $ch);

                    //add curl handle of a new request to the request map
                    $key = (string) $ch;
                    $requests_map[$key] = $i;
                    $i++;
                }
            }
            if($active) {
                if(curl_multi_select($multi_handle, $this->_timeout) === -1) { //wait for activity on any connection
                    usleep(5);
                }

            }
        } while ($active || count($requests_map)); //End do-while

        $this->reset();
        curl_multi_close($multi_handle);
    }



    //Build individual cURL options for a request
    private function buildOptions(array $request) {
        $url = $request['url'];
        $post_data = $request['post_data'];
        $individual_opts = $request['options'];
        $individual_headers = $request['headers'];

        $options = ($individual_opts) ? $individual_opts + $this->_options : $this->_options; //merge shared and individual request options
        $headers = ($individual_headers) ? $individual_headers + $this->_headers : $this->_headers; //merge shared and individual request headers

        //the below will overide the corresponding default or individual options
        $options[CURLOPT_RETURNTRANSFER] = true;
        //$options[CURLOPT_TIMEOUT] = $this->_timeout; //timeout in ms. bug in php 5.3 
		$options[CURLOPT_TIMEOUT] = 5; //timeout in seconds;
        if($url) {
            $options[CURLOPT_URL] = $url;
        }

        if($headers) {
            $options[CURLOPT_HTTPHEADER] = $headers;
        }

        // enable POST method and set POST parameters
        if($post_data) {
            $options[CURLOPT_POST] = 1;
            $options[CURLOPT_POSTFIELDS] = is_array($post_data)? http_build_query($post_data) : $post_data;
        }
        return $options;
    }



    private function addTimer(array &$request) { //adds timer object to request
        $request['timer'] = microtime(true);
        $request['time'] = false; //default if not overridden by time later
    }

    private function stopTimer(array &$request) {
        $start_time = $request['timer'];
        $end_time = microtime(true);
        $elapsed_time = rtrim(sprintf('%.20F', ($end_time - $start_time)), '0') . 'secs'; //convert float to string
        $request['time'] = $elapsed_time*1000; //
        unset($request['timer']);
    }
}