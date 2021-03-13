<?php

class Request
{
	public $method;
	private $input_data;
	private $urls;

	public function __construct() {

		// Request method
		$this->method = $_SERVER['REQUEST_METHOD'];

	    // URL parts array
		$this->urls = explode('/', rtrim($_GET['q'], '/'));

		// Request body
		if ($this->method == 'GET') $this->input_data = $_GET;

	    else {

	    	if ($_SERVER['CONTENT_TYPE'] == 'application/json') {

	    		$this->input_data = json_decode(file_get_contents('php://input'));

	    	} else {

			    $exploded = explode('&', file_get_contents('php://input'));

			    foreach($exploded as $pair) {
			        $item = explode('=', $pair);
			        if (count($item) == 2) {
			            $this->input_data[urldecode($item[0])] = urldecode($item[1]);
			        }
			    }
			}
	    }
	}

    /**
     * Returns list of the URL parts.
     *
     * @return array
     */
	public function urls() {
		return $this->urls;
	}

    /**
     * Returns request data.
     *
     * @return array
     */
	public function input() {
		return $this->input_data;
	}
}