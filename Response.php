<?php

class Response
{
    /**
     * Create response.
     *
     * @param boolean $success
     * @param string $message
     * @param array $data
     *
     * @return json
     */
	public static function send($success=FALSE, $message=NULL, $data=NULL) {

		$response = [];
		$response['success'] = $success;
		if (!empty($message)) $response['message'] = $message;
		if (!empty($data)) $response['data'] = $data;

		if (!$success) header('HTTP/1.0 400 Bad Request');
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
		header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");

		return json_encode($response);
	}
}